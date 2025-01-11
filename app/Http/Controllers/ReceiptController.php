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

        // Expense Debit
        $expenseAccount = Account::findOrFail(Variable::where('title', 'expense_account')->first()->value);
        $this->createTransaction($expenseAccount->id, $totalCostAfterVAT - $totalTax, 0, $receipt);

        // Tax Debit
        if($totalTax != 0){
            $taxAccount = Tax::findOrFail($validatedData['tax_id'])->account;
            $this->createTransaction($taxAccount->id, $totalTax, 0, $receipt);
        }

        // Supplier Credit
        $supplier = Supplier::findOrFail($validatedData['supplier_id']);
        $this->createTransaction(
            $supplier->payable_account_id,
            0,
            $totalCostAfterVAT,
            $receipt,
            $supplier->id
        );

        Log::create(['text' => ucwords(auth()->user()->name) . " created new Receipt: " . $receipt->receipt_number . ", datetime: " . now()]);

        return redirect()->route('receipts')->with('success', 'Receipt created successfully!');
    }

    public function edit(Receipt $receipt)
    {
        $items = Item::select('id', 'name')->where('type', 'expense')->get();
        $taxes = Tax::select('id', 'name', 'rate')->get();
        $suppliers = Supplier::select('id', 'name')->get();

        $total = 0;
        $total_after_tax = 0;
        $total_tax = 0;

        foreach ($receipt->receipt_items as $item) {
            $total += $item->total_cost;
            $total_tax += $item->vat;
            $total_after_tax += $item->total_cost_after_vat;
        }

        $data = compact('receipt', 'items', 'taxes', 'suppliers', 'total', 'total_after_tax', 'total_tax');

        return view('receipts.edit', $data);
    }

    public function update(Receipt $receipt, Request $request)
    {
        $validatedData = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'supplier_invoice' => 'required|string|max:255|unique:receipts,supplier_invoice,' . $receipt->id,
            'tax_id' => 'required|exists:taxes,id',
            'currency_id' => 'required|exists:currencies,id',
            'date' => 'required|date',
            'item_id.*' => 'required|exists:items,id',
            'quantity.*' => 'required|numeric|min:1',
            'unit_cost.*' => 'required|numeric|min:0',
        ]);

        $receipt->update([
            'supplier_invoice' => $request->input('supplier_invoice'),
            'tax_id' => $request->input('tax_id'),
            'currency_id' => $request->input('currency_id'),
            'date' => $request->input('date'),
        ]);

        $totalItemCost = 0;
        $totalTax = 0;
        $taxRate = Tax::findOrFail($validatedData['tax_id'])->rate / 100;

        // Create new receipt items
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

        // Expense Debit
        $expenseAccount = Account::findOrFail(Variable::where('title', 'expense_account')->first()->value);
        $this->createTransaction($expenseAccount->id, $totalCostAfterVAT - $totalTax, 0, $receipt);

        // Tax Debit
        $taxAccount = Tax::findOrFail($validatedData['tax_id'])->account;
        $this->createTransaction($taxAccount->id, $totalTax, 0, $receipt);

        // Supplier Credit
        $supplier = Supplier::findOrFail($validatedData['supplier_id']);
        $this->createTransaction(
            $supplier->payable_account_id,
            0,
            $totalCostAfterVAT,
            $receipt,
            $supplier->id
        );

        $text = ucwords(auth()->user()->name) . ' updated Receipt ' . $receipt->receipt_number . ", datetime :   " . now();
        Log::create(['text' => $text]);

        return redirect()->back()->with('warning', 'Receipt updated successfully!');
    }

    public function show(Receipt $receipt)
    {
        $total = 0;
        $total_tax = 0;
        $total_after_tax = 0;

        foreach ($receipt->receipt_items as $item) {
            $total += $item->total_cost;
            $total_tax += $item->vat;
            $total_after_tax += $item->total_cost_after_vat;
        }

        $data = compact('receipt', 'total', 'total_tax', 'total_after_tax');
        return view('receipts.show', $data);
    }

    public function Return(Receipt $receipt)
    {
        $receipts = Receipt::select('id', 'receipt_number')->where('type', 'receipt')->get();
        return view('receipts.return', compact('receipt', 'receipts'));
    }

    public function ReturnSave(Request $request)
    {
        $request->validate([
            'receipt_id' => 'required',
            'items' => 'required|array',
        ]);

        $old_receipt = Receipt::find($request->input('receipt_id'));
        $return_number = Receipt::generate_return_number();

        $receipt = Receipt::create([
            'receipt_number' => $return_number,
            'supplier_id' => $old_receipt->supplier_id,
            'supplier_invoice' => $old_receipt->supplier_invoice,
            'tax_id' => $old_receipt->tax_id,
            'currency_id' => $old_receipt->currency_id,
            'date' => date('Y-m-d'),
            'type' => 'return',
        ]);

        $total = 0;
        $total_tax = 0;

        $tax_rate = $old_receipt->tax->rate / 100;
        foreach ($request->items as $index => $item) {
            if (isset($item['id'])) {
                $old_receipt_item = ReceiptItem::find($item['id']);
                $original_unit_cost = $old_receipt_item->unit_cost;
                $t = $original_unit_cost * $item['quantity'];
                $total += $t;

                $vat = $t * $tax_rate;
                $total_tax += $vat;
            }
        }

        foreach ($request->items as $index => $item) {
            if (isset($item['id'])) {
                $old_receipt_item = ReceiptItem::find($item['id']);
                $original_unit_cost = $old_receipt_item->unit_cost;
                $t = $original_unit_cost * $item['quantity'];

                $vat = $t * $tax_rate;
                $total_cost_after_vat = $t + $vat;

                $landed_cost_per_item = ($original_unit_cost / $total) * $total_landed_cost;

                $total_after_landed_cost = $t + $landed_cost_per_item;
                $total_lc += ($total_after_landed_cost - $vat);
                $unit_cost = $total_after_landed_cost / $item['quantity'];

                ReceiptItem::create([
                    'receipt_id' => $receipt->id,
                    'item_id' => $old_receipt_item->item_id,
                    'quantity' => $item['quantity'],
                    'unit_cost' => $original_unit_cost,
                    'total_cost' => $t,
                    'vat' => $vat,
                    'total_cost_after_vat' => $total_cost_after_vat,
                    'total_after_landed_cost' => $total_after_landed_cost,
                ]);


                $old_receipt_item->item->update_unit_cost($unit_cost);
            }
        }

        // create inventory credit transaction
        $inventory_account = $old_receipt_item->item->inventory_account;
        Transaction::create([
            'user_id' => auth()->user()->id,
            'account_id' => $inventory_account->id,
            'currency_id' => $receipt->currency_id,
            'debit' => 0,
            'credit' => $total_lc,
            'balance' => 0 - $total_lc,
        ]);

        // create tax credit transaction
        $account = $old_receipt->tax->account;
        Transaction::create([
            'user_id' => auth()->user()->id,
            'account_id' => $account->id,
            'currency_id' => $receipt->currency_id,
            'debit' => 0,
            'credit' => $total_tax,
            'balance' => 0 - $total_tax,
        ]);

        // create supplier credit transaction
        $supplier = $old_receipt->supplier;
        Transaction::create([
            'user_id' => auth()->user()->id,
            'account_id' => $supplier->payable_account_id,
            'supplier_id' => $supplier->id,
            'currency_id' => $receipt->currency_id,
            'debit' => $total_lc + $total_tax - $total_landed_cost,
            'credit' => 0,
            'balance' => $total_lc + $total_tax - $total_landed_cost,
        ]);

        Log::create([
            'text' => ucwords(auth()->user()->name) . ' Returned Receipts ' . $receipt->receipt_number . ", datetime :   " . now(),
        ]);

        return redirect()->route('receipts')->with('success', 'Receipts Returned successfully!');
    }

    public function items(Receipt $receipt)
    {
        $items = $receipt->receipt_items;

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
    private function createTransaction($accountId, $debit, $credit, $receipt, $supplierId = null)
    {
        Transaction::create([
            'user_id' => auth()->id(),
            'account_id' => $accountId,
            'supplier_id' => $supplierId,
            'currency_id' => $receipt->currency_id,
            'debit' => $debit,
            'credit' => $credit,
            'balance' => $debit - $credit,
        ]);
    }
}
