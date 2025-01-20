<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Item;
use App\Models\Log;
use App\Models\Receipt;
use App\Models\ReceiptItem;
use App\Models\Supplier;
use App\Models\Tax;
use App\Models\Transaction;
use App\Models\Variable;
use Illuminate\Http\Request;

class ReceiptController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:receipts.read')->only('index');
        $this->middleware('permission:receipts.create')->only(['new', 'create']);
        $this->middleware('permission:receipts.update')->only(['edit', 'update']);
        $this->middleware('permission:receipts.delete')->only('destroy');
        $this->middleware('permission:receipts.export')->only('export');
    }

    public function index()
    {
        $receipts = Receipt::select('id', 'receipt_number', 'supplier_invoice', 'date', 'supplier_id', 'tax_id', 'currency_id')->filter()->orderBy('id', 'desc')->paginate(25);
        $suppliers = Supplier::select('id', 'name')->get();
        $taxes = Tax::select('id', 'name')->get();

        $data = compact('receipts', 'suppliers', 'taxes');
        return view('receipts.index', $data);
    }

    public function new()
    {
        $items = Item::select('id', 'name', 'unit_price', 'unit', 'type')->where('type', 'expense')->get();
        $taxes = Tax::select('id', 'name', 'rate')->get();
        $suppliers = Supplier::select('id', 'name')->get();
        $data = compact('suppliers', 'items', 'taxes');

        return view('receipts.new', $data);
    }

    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'supplier_invoice' => 'required|string|max:255|unique:receipts',
            'tax_id' => 'required|exists:taxes,id',
            'currency_id' => 'required|exists:currencies,id',
            'date' => 'required|date',
            'item_id.*' => 'required|exists:items,id',
            'quantity.*' => 'required|numeric|min:1',
            'unit_cost.*' => 'required|numeric|min:0',
        ]);

        $number = Receipt::generate_number();
        $taxRate = Tax::findOrFail($validatedData['tax_id'])->rate / 100;

        // Create Receipt
        $receipt = Receipt::create([
            'receipt_number' => $number,
            'supplier_invoice' => $validatedData['supplier_invoice'],
            'supplier_id' => $validatedData['supplier_id'],
            'tax_id' => $validatedData['tax_id'],
            'currency_id' => $validatedData['currency_id'],
            'date' => $validatedData['date'],
            'purchase_order_id' => $validatedData['purchase_order_id'] ?? null,
            'type' => 'receipt',
        ]);

        $totalItemCost = 0;
        $totalTax = 0;

        foreach ($validatedData['item_id'] as $key => $itemId) {
            $quantity = $validatedData['quantity'][$key];
            $unitCost = $validatedData['unit_cost'][$key];
            $totalCost = $unitCost * $quantity;
            $vat = $totalCost * $taxRate;

            ReceiptItem::create([
                'receipt_id' => $receipt->id,
                'item_id' => $itemId,
                'quantity' => $quantity,
                'unit_cost' => $unitCost,
                'total_cost' => $totalCost,
                'vat' => $vat,
                'total_cost_after_vat' => $totalCost + $vat,
            ]);

            $totalItemCost += $totalCost;
            $totalTax += $vat;
        }

        $totalCostAfterVAT = $totalItemCost + $totalTax;

        // Cash Credit Transaction
        $cashAccount = Account::findOrFail(Variable::where('title', 'cash_account')->first()->value);
        $this->createTransaction(
            $cashAccount->id,
            0,
            $totalCostAfterVAT - $totalTax,
            $receipt,
            null,
            'Cash Payment for Receipt',
            "Cash payment for receipt {$receipt->receipt_number}."
        );

        // Tax Credit Transaction
        if ($totalTax != 0) {
            $taxAccount = Tax::findOrFail($validatedData['tax_id'])->account;
            $this->createTransaction(
                $taxAccount->id,
                0,
                $totalTax,
                $receipt,
                null,
                'Tax Payment for Receipt',
                "Tax payment for receipt {$receipt->receipt_number}."
            );
        }

        // Supplier Debit Transaction
        $supplier = Supplier::findOrFail($validatedData['supplier_id']);
        $payableAccount = Account::findOrFail(Variable::where('title', 'payable_account')->first()->value);
        $this->createTransaction(
            $payableAccount->id,
            $totalCostAfterVAT,
            0,
            $receipt,
            $supplier->id,
            'Supplier Payment for Receipt',
            "Payment to supplier {$supplier->name} for receipt {$receipt->receipt_number}."
        );

        Log::create(['text' => ucwords(auth()->user()->name) . " created new Receipt: " . $receipt->receipt_number . ", datetime: " . now()]);

        return redirect()->route('receipts')->with('success', 'Receipt created successfully!');
    }

    public function edit(Receipt $receipt)
    {
        $items = Item::select('id', 'name')->where('type', 'expense')->get();
        $suppliers = Supplier::select('id', 'name')->get();

        $data = compact('receipt', 'items', 'suppliers');
        return view('receipts.edit', $data);
    }

    public function update(Receipt $receipt, Request $request)
    {
        $validatedData = $request->validate([
            'supplier_invoice' => 'required|string|max:255|unique:receipts,supplier_invoice,' . $receipt->id,
            'date' => 'required|date',
        ]);

        $receipt->update([
            'supplier_invoice' => $request->input('supplier_invoice'),
            'date' => $request->input('date'),
        ]);

        if ($request->item_id) {
            $taxRate = $receipt->tax->rate / 100;
            $totalItemCost = 0;
            $totalTax = 0;

            foreach ($validatedData['item_id'] as $key => $itemId) {
                $quantity = $validatedData['quantity'][$key];
                $unitCost = $validatedData['unit_cost'][$key];
                $totalCost = $unitCost * $quantity;
                $vat = $totalCost * $taxRate;

                ReceiptItem::create([
                    'receipt_id' => $receipt->id,
                    'item_id' => $itemId,
                    'quantity' => $quantity,
                    'unit_cost' => $unitCost,
                    'total_cost' => $totalCost,
                    'vat' => $vat,
                    'total_cost_after_vat' => $totalCost + $vat,
                ]);

                $totalItemCost += $totalCost;
                $totalTax += $vat;
            }

            $totalCostAfterVAT = $totalItemCost + $totalTax;

            // Cash Credit Transaction
            $cashAccount = Account::findOrFail(Variable::where('title', 'cash_account')->first()->value);
            $this->createTransaction(
                $cashAccount->id,
                0,
                $totalCostAfterVAT - $totalTax,
                $receipt,
                null,
                'Cash Payment for Receipt',
                "Cash payment for receipt {$receipt->receipt_number}."
            );

            // Tax Credit Transaction
            if ($totalTax != 0) {
                $taxAccount = Tax::findOrFail($validatedData['tax_id'])->account;
                $this->createTransaction(
                    $taxAccount->id,
                    0,
                    $totalTax,
                    $receipt,
                    null,
                    'Tax Payment for Receipt',
                    "Tax payment for receipt {$receipt->receipt_number}."
                );
            }

            // Supplier Debit Transaction
            $supplier = Supplier::findOrFail($validatedData['supplier_id']);
            $payableAccount = Account::findOrFail(Variable::where('title', 'payable_account')->first()->value);
            $this->createTransaction(
                $payableAccount->id,
                $totalCostAfterVAT,
                0,
                $receipt,
                $supplier->id,
                'Supplier Payment for Receipt',
                "Payment to supplier {$supplier->name} for receipt {$receipt->receipt_number}."
            );
        }

        $text = ucwords(auth()->user()->name) . ' updated Receipt ' . $receipt->receipt_number . ", datetime :   " . now();
        Log::create(['text' => $text]);

        return redirect()->back()->with('warning', 'Receipt updated successfully!');
    }

    public function show(Receipt $receipt)
    {
        $items = $receipt->items;

        $data = compact('receipt', 'items');
        return view('receipts.show', $data);
    }

    public function items(Receipt $receipt)
    {
        $items = $receipt->items;

        $customizedItems = [];
        $index = 0;
        foreach ($items as $item) {
            $customizedItem = [
                'id' => $item->id,
                'name' => $item->item->itemcode,
                'quantity' => $item->quantity,
            ];
            $customizedItems[] = $customizedItem;
            $index++;
        }

        return response()->json($customizedItems);
    }

    public function destroy(Receipt $receipt)
    {
        if ($receipt->can_delete()) {
            $text = ucwords(auth()->user()->name) . " deleted Receipt : " . $receipt->receipt_number . ", datetime :   " . now();

            foreach ($receipt->items as $item) {
                $item->delete();
            }

            Log::create(['text' => $text]);
            $receipt->delete();

            return redirect()->back()->with('error', 'Receipt deleted successfully!');
        } else {
            return redirect()->back()->with('error', 'Unable to delete...');
        }
    }

    // -------------------
    // Private
    // -------------------
    private function createTransaction($accountId, $debit, $credit, $receipt, $supplierId = null,  $title = null, $description = null)
    {
        Transaction::create([
            'user_id' => auth()->id(),
            'account_id' => $accountId,
            'supplier_id' => $supplierId,
            'currency_id' => $receipt->currency_id,
            'debit' => $debit,
            'credit' => $credit,
            'balance' => $debit - $credit,
            'title' => $title,
            'description' => $description,
        ]);
    }
}
