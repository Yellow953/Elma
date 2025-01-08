<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Item;
use App\Models\Log;
use App\Models\Supplier;
use App\Models\Tax;
use App\Models\Transaction;
use App\Models\Variable;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:invoices.read')->only('index');
        $this->middleware('permission:invoices.create')->only(['new', 'create']);
        $this->middleware('permission:invoices.update')->only(['edit', 'update']);
        $this->middleware('permission:invoices.delete')->only('destroy');
        $this->middleware('permission:invoices.export')->only('export');
    }

    public function index()
    {
        $invoices = Invoice::select('id', 'invoice_number', 'date', 'client_id', 'currency_id', 'foreign_currency_id')->filter()->orderBy('id', 'desc')->paginate(25);
        $clients = Client::select('id', 'name')->get();

        $data = compact('invoices', 'clients');
        return view('invoices.index', $data);
    }

    public function new()
    {
        $clients = Client::select('id', 'name', 'tax_id')->get();
        $items = Item::select('id', 'name', 'unit_price', 'unit', 'type')->get();
        $taxes = Tax::select('id', 'name', 'rate')->get();
        $suppliers = Supplier::select('id', 'name')->get();

        $data = compact('clients', 'items', 'taxes', 'suppliers');
        return view('invoices.new', $data);
    }

    public function create(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'tax_id' => 'required|exists:taxes,id',
            'currency_id' => 'required|exists:currencies,id',
            'foreign_currency_id' => 'nullable|exists:currencies,id',
            'date' => 'required|date',
            'item_id.*' => 'required|exists:items,id',
            'quantity.*' => 'required|numeric|min:1',
            'unit_price.*' => 'required|numeric|min:0',
            'supplier_id.*' => 'nullable|exists:suppliers,id',
        ]);

        $number = Invoice::generate_number();

        // Create Invoice
        $invoice = Invoice::create([
            'invoice_number' => $number,
            'client_id' => $request->client_id,
            'tax_id' => $request->tax_id,
            'currency_id' => $request->currency_id,
            'foreign_currency_id' => $request->foreign_currency_id,
            'rate' => $request->rate,
            'date' => $request->date,
            'type' => 'invoice',
        ]);

        $total_price = 0;
        $total_tax = 0;
        $total_after_tax = 0;

        $tax_rate = $invoice->tax->rate / 100;

        foreach ($request->item_id as $key => $itemId) {
            $item = Item::findOrFail($itemId);
            $quantity = $request->quantity[$key];
            $unit_price = $request->unit_price[$key];
            $supplier_id = $request->supplier_id[$key] ?? null;

            $line_total = $quantity * $unit_price;
            $line_tax = $line_total * $tax_rate;
            $line_total_after_tax = $line_total + $line_tax;

            InvoiceItem::create([
                'invoice_id' => $invoice->id,
                'item_id' => $itemId,
                'supplier_id' => $supplier_id,
                'type' => $supplier_id ? 'expense' : 'item',
                'quantity' => $quantity,
                'unit_cost' => 0,
                'unit_price' => $unit_price,
                'total_cost' => 0,
                'total_price' => $line_total,
                'vat' => $line_tax,
                'rate' => $request->rate,
                'total_price_after_vat' => $line_total_after_tax,
                'total_foreign_price' => $line_total_after_tax * $request->rate,
            ]);

            $total_price += $line_total;
            $total_tax += $line_tax;
            $total_after_tax += $line_total_after_tax;

            if ($supplier_id) {
                $expense_account = Account::findOrFail(Variable::where('title', 'expense_account')->first()->value);

                // Expense Transaction
                Transaction::create([
                    'user_id' => auth()->id(),
                    'account_id' => $expense_account->id,
                    'currency_id' => $invoice->currency_id,
                    'foreign_currency_id' => $invoice->foreign_currency_id,
                    'rate' => $request->rate,
                    'debit' => $line_total_after_tax,
                    'credit' => 0,
                    'balance' => $line_total_after_tax,
                    'foreign_debit' => $line_total_after_tax * $request->rate,
                    'foreign_credit' => 0,
                    'foreign_balance' => $line_total_after_tax * $request->rate,
                ]);

                // Supplier Payable Transaction
                $supplier_account = Supplier::find($supplier_id)->payable_account;

                Transaction::create([
                    'user_id' => auth()->id(),
                    'account_id' => $supplier_account->id,
                    'supplier_id' => $supplier_id,
                    'currency_id' => $invoice->currency_id,
                    'foreign_currency_id' => $invoice->foreign_currency_id,
                    'rate' => $request->rate,
                    'debit' => 0,
                    'credit' => $line_total_after_tax,
                    'balance' => -$line_total_after_tax,
                    'foreign_debit' => 0,
                    'foreign_credit' => $line_total_after_tax * $request->rate,
                    'foreign_balance' => - ($line_total_after_tax * $request->rate),
                ]);
            }
        }

        // Tax Payable Transaction
        Transaction::create([
            'user_id' => auth()->id(),
            'account_id' => $invoice->tax->account->id,
            'currency_id' => $invoice->currency_id,
            'foreign_currency_id' => $invoice->foreign_currency_id,
            'rate' => $request->rate,
            'debit' => 0,
            'credit' => $total_tax,
            'balance' => -$total_tax,
            'foreign_debit' => 0,
            'foreign_credit' => $total_tax * $request->rate,
            'foreign_balance' => - ($total_tax * $request->rate),
        ]);

        // Client Receivable Transaction
        $receivable_account = $invoice->client->receivable_account;

        Transaction::create([
            'user_id' => auth()->id(),
            'account_id' => $receivable_account->id,
            'client_id' => $invoice->client_id,
            'currency_id' => $invoice->currency_id,
            'foreign_currency_id' => $invoice->foreign_currency_id,
            'rate' => $request->rate,
            'debit' => $total_after_tax,
            'credit' => 0,
            'balance' => $total_after_tax,
            'foreign_debit' => $total_after_tax * $request->rate,
            'foreign_credit' => 0,
            'foreign_balance' => $total_after_tax * $request->rate,
        ]);

        // Revenue Transaction
        $revenue_account = Account::findOrFail(Variable::where('title', 'revenue_account')->first()->value);

        Transaction::create([
            'user_id' => auth()->id(),
            'account_id' => $revenue_account->id,
            'currency_id' => $invoice->currency_id,
            'foreign_currency_id' => $invoice->foreign_currency_id,
            'rate' => $request->rate,
            'debit' => 0,
            'credit' => $total_price,
            'balance' => -$total_price,
            'foreign_debit' => 0,
            'foreign_credit' => $total_price * $request->rate,
            'foreign_balance' => - ($total_price * $request->rate),
        ]);

        Log::create([
            'text' => auth()->user()->name . " created Invoice " . $invoice->invoice_number . " on " . now(),
        ]);

        return redirect()->route('invoices')->with('success', 'Invoice created successfully.');
    }

    public function edit(Invoice $invoice)
    {
        $items = Item::select('id', 'name', 'unit_price', 'type')->get();
        $taxes = Tax::select('id', 'name', 'rate')->get();

        $total = 0;
        $total_tax = 0;
        $total_after_tax = 0;
        $total_foreign = 0;

        foreach ($invoice->invoice_items as $item) {
            $total += $item->total_price;
            $total_tax += $item->vat;
            $total_after_tax += $item->total_price_after_vat;
            $total_foreign += $item->total_foreign_price;
        }

        $data = compact('invoice', 'items', 'taxes', 'total', 'total_tax', 'total_after_tax', 'total_foreign');
        return view('invoices.edit', $data);
    }

    public function update(Invoice $invoice, Request $request)
    {
        $request->validate([
            'tax_id' => 'required|exists:taxes,id',
            'currency_id' => 'required|exists:currencies,id',
            'foreign_currency_id' => 'required|exists:currencies,id',
            'date' => 'required|date',
        ]);

        $invoice->update([
            'tax_id' => $request->input('tax_id'),
            'currency_id' => $request->input('currency_id'),
            'foreign_currency_id' => $request->input('foreign_currency_id'),
            'rate' => $request->input('rate'),
            'date' => $request->input('date'),
        ]);

        $taxes = 0;
        $total_after_tax = 0;
        $rate = $request->input('rate');

        $tax_rate = Tax::find($request->input('tax_id'))->rate / 100;
        if ($request->input('item_id')[0] != null) {
            foreach ($request->input('item_id') as $key => $itemId) {
                $item = Item::find($itemId);
                $quantity = $request->input('quantity')[$key];
                $unit_cost =  $item->unit_cost;
                $unit_price =  $request->input('unit_price')[$key];
                $tc = $quantity * $unit_cost;
                $tp = $quantity * $unit_price;

                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'item_id' => $itemId,
                    'quantity' => $quantity,
                    'unit_cost' => $unit_cost,
                    'total_cost' => $tc,
                    'unit_price' => $unit_price,
                    'total_price' => $tp,
                    'vat' => ($tp * $tax_rate),
                    'rate' => $rate,
                    'total_price_after_vat' =>  $tp + ($tp * $tax_rate),
                    'total_foreign_price' => ($tp + ($tp * $tax_rate)) * $rate,
                ]);
                $taxes += ($tp * $tax_rate);
                $total_after_tax += $tp + ($tp * $tax_rate);

                // create inventory credit transaction
                $inventory_account = $item->inventory_account;
                Transaction::create([
                    'user_id' => auth()->user()->id,
                    'account_id' => $inventory_account->id,
                    'currency_id' => $invoice->currency_id,
                    'debit' => 0,
                    'credit' => $tc,
                    'balance' => 0 - $tc,
                    'foreign_currency_id' => $invoice->foreign_currency_id,
                    'rate' => $rate,
                    'foreign_debit' => 0,
                    'foreign_credit' => ($tc * $rate),
                    'foreign_balance' => 0 - ($tc * $rate),
                ]);

                // create cost of sales debit transaction
                $cost_of_sales_account = Item::find($itemId)->cost_of_sales_account;
                Transaction::create([
                    'user_id' => auth()->user()->id,
                    'account_id' => $cost_of_sales_account->id,
                    'currency_id' => $invoice->currency_id,
                    'debit' => $tc,
                    'credit' => 0,
                    'balance' => $tc,
                    'foreign_currency_id' => $invoice->foreign_currency_id,
                    'rate' => $rate,
                    'foreign_debit' => ($tc * $rate),
                    'foreign_credit' => 0,
                    'foreign_balance' => ($tc * $rate),
                ]);

                // create sales credit transaction
                $sales_account = Item::find($itemId)->sales_account;
                Transaction::create([
                    'user_id' => auth()->user()->id,
                    'account_id' => $sales_account->id,
                    'currency_id' => $invoice->currency_id,
                    'debit' => 0,
                    'credit' => $tp,
                    'balance' => 0 - $tp,
                    'foreign_currency_id' => $invoice->foreign_currency_id,
                    'rate' => $rate,
                    'foreign_debit' => 0,
                    'foreign_credit' => ($tp * $rate),
                    'foreign_balance' => 0 - ($tp * $rate),
                ]);
            }
        }

        // create taxes credit transaction
        $tax_account = $invoice->tax->account;
        if ($taxes != 0) {
            Transaction::create([
                'user_id' => auth()->user()->id,
                'account_id' => $tax_account->id,
                'currency_id' => $invoice->currency_id,
                'debit' => 0,
                'credit' => $taxes,
                'balance' => 0 - $taxes,
                'foreign_currency_id' => $invoice->foreign_currency_id,
                'rate' => $rate,
                'foreign_debit' => 0,
                'foreign_credit' => ($taxes * $rate),
                'foreign_balance' => 0 - ($taxes * $rate),
            ]);
        }

        // create client debit transaction
        $receivable_account = $invoice->client->receivable_account;
        if ($total_after_tax != 0) {
            Transaction::create([
                'user_id' => auth()->user()->id,
                'account_id' => $receivable_account->id,
                'client_id' => $invoice->client_id,
                'currency_id' => $invoice->currency_id,
                'debit' => $total_after_tax,
                'credit' => 0,
                'balance' => $total_after_tax,
                'foreign_currency_id' => $invoice->foreign_currency_id,
                'rate' => $rate,
                'foreign_debit' => ($total_after_tax * $rate),
                'foreign_credit' => 0,
                'foreign_balance' => ($total_after_tax * $rate),
            ]);
        }

        $text = ucwords(auth()->user()->name) . ' updated Invoice ' . $invoice->invoice_number . ", datetime :   " . now();
        Log::create(['text' => $text]);

        return redirect()->back()->with('warning', 'Invoice updated successfully!');
    }

    public function show(Invoice $invoice)
    {
        $total_cost = 0;
        $total_price = 0;
        $total_tax = 0;
        $total_after_tax = 0;
        $total_foreign = 0;

        foreach ($invoice->invoice_items as $item) {
            $total_cost += $item->total_cost;
            $total_price += $item->total_price;
            $total_tax += $item->vat;
            $total_after_tax += $item->total_price_after_vat;
            $total_foreign += $item->total_foreign_price;
        }

        $data = compact('invoice', 'total_cost', 'total_price', 'total_tax', 'total_after_tax', 'total_foreign');
        return view('invoices.show', $data);
    }

    public function Return(Invoice $invoice)
    {
        $invoices = Invoice::select('id', 'invoice_number')->where('type', 'invoice')->get();
        return view('invoices.return', compact('invoice', 'invoices'));
    }

    public function ReturnSave(Request $request)
    {
        $request->validate([
            'invoice_id' => 'required',
            'items' => 'required|array',
        ]);

        $old_invoice = Invoice::find($request->input('invoice_id'));
        $return_number = Invoice::generate_return_number();

        $invoice = Invoice::create([
            'invoice_number' => $return_number,
            'client_id' => $old_invoice->client_id,
            'tax_id' => $old_invoice->tax_id,
            'currency_id' => $old_invoice->currency_id,
            'foreign_currency_id' => $old_invoice->foreign_currency_id,
            'rate' => $old_invoice->rate,
            'date' => date('Y-m-d'),
            'type' => 'return',
        ]);

        $taxes = 0;
        $total_after_tax = 0;
        $rate = $old_invoice->rate;
        $tax_rate = $old_invoice->tax->rate / 100;

        foreach ($request->items as $index => $item) {
            if (isset($item['id'])) {
                $old_invoice_item = InvoiceItem::find($item['id']);
                $old_item = $old_invoice_item->item;
                $tc = $item['quantity'] * $old_invoice_item->unit_cost;
                $tp = $item['quantity'] * $old_invoice_item->unit_price;

                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'item_id' => $old_item->id,
                    'quantity' => $item['quantity'],
                    'unit_cost' => $old_invoice_item->unit_cost,
                    'total_cost' => $tc,
                    'unit_price' => $old_invoice_item->unit_price,
                    'total_price' => $tp,
                    'vat' => ($tp * $tax_rate),
                    'rate' => $rate,
                    'total_price_after_vat' =>  $tp + ($tp * $tax_rate),
                    'total_foreign_price' => ($tp + ($tp * $tax_rate)) * $rate,
                ]);
                $taxes += ($tp * $tax_rate);
                $total_after_tax += $tp + ($tp * $tax_rate);

                // reverse inventory credit transaction
                $inventory_account = $old_item->inventory_account;
                Transaction::create([
                    'user_id' => auth()->user()->id,
                    'account_id' => $inventory_account->id,
                    'currency_id' => $invoice->currency_id,
                    'debit' => $tc,
                    'credit' => 0,
                    'balance' => $tc,
                    'foreign_currency_id' => $invoice->foreign_currency_id,
                    'rate' => $rate,
                    'foreign_debit' => ($tc * $rate),
                    'foreign_credit' => 0,
                    'foreign_balance' => ($tc * $rate),
                ]);

                // reverse cost of sales debit transaction
                $cost_of_sales_account = $old_item->cost_of_sales_account;
                Transaction::create([
                    'user_id' => auth()->user()->id,
                    'account_id' => $cost_of_sales_account->id,
                    'currency_id' => $invoice->currency_id,
                    'debit' => 0,
                    'credit' => $tc,
                    'balance' => 0 - $tc,
                    'foreign_currency_id' => $invoice->foreign_currency_id,
                    'rate' => $rate,
                    'foreign_debit' => 0,
                    'foreign_credit' => ($tc * $rate),
                    'foreign_balance' => 0 - ($tc * $rate),
                ]);

                // reverse sales credit transaction
                $sales_account = $old_item->sales_account;
                Transaction::create([
                    'user_id' => auth()->user()->id,
                    'account_id' => $sales_account->id,
                    'currency_id' => $invoice->currency_id,
                    'debit' => $tp,
                    'credit' => 0,
                    'balance' => $tp,
                    'foreign_currency_id' => $invoice->foreign_currency_id,
                    'rate' => $rate,
                    'foreign_debit' => ($tp * $rate),
                    'foreign_credit' => 0,
                    'foreign_balance' => ($tp * $rate),
                ]);
            }
        }

        // reverse taxes debit transaction
        $tax_account = $invoice->tax->account;
        Transaction::create([
            'user_id' => auth()->user()->id,
            'account_id' => $tax_account->id,
            'currency_id' => $invoice->currency_id,
            'debit' => $taxes,
            'credit' => 0,
            'balance' => $taxes,
            'foreign_currency_id' => $invoice->foreign_currency_id,
            'rate' => $rate,
            'foreign_debit' => ($taxes * $rate),
            'foreign_credit' => 0,
            'foreign_balance' => ($taxes * $rate),
        ]);

        // reverse client credit transaction
        $receivable_account = $invoice->client->receivable_account;
        Transaction::create([
            'user_id' => auth()->user()->id,
            'account_id' => $receivable_account->id,
            'client_id' => $invoice->client_id,
            'currency_id' => $invoice->currency_id,
            'debit' => 0,
            'credit' => $total_after_tax,
            'balance' => 0 - $total_after_tax,
            'foreign_currency_id' => $invoice->foreign_currency_id,
            'rate' => $rate,
            'foreign_debit' => 0,
            'foreign_credit' => ($total_after_tax * $rate),
            'foreign_balance' => 0 - ($total_after_tax * $rate),
        ]);

        Log::create([
            'text' => ucwords(auth()->user()->name) . ' Returned Invoice ' . $invoice->invoice_number . ", datetime :   " . now(),
        ]);

        return redirect()->route('invoices')->with('success', 'Invoice Returned successfully!');
    }

    public function items(Invoice $invoice)
    {
        $items = $invoice->invoice_items;

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

    public function destroy(Invoice $invoice)
    {
        $text = ucwords(auth()->user()->name) . " deleted Invoice : " . $invoice->invoice_number . ", datetime :   " . now();

        Log::create(['text' => $text]);
        $invoice->delete();

        return redirect()->back()->with('error', 'Invoice deleted successfully!');
    }
}
