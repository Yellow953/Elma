<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Account;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Item;
use App\Models\Log;
use App\Models\Shipment;
use App\Models\Supplier;
use App\Models\Tax;
use App\Models\Transaction;
use App\Models\Variable;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:invoices.read')->only(['index', 'show']);
        $this->middleware('permission:invoices.create')->only(['new', 'create']);
        $this->middleware('permission:invoices.update')->only(['edit', 'update']);
        $this->middleware('permission:invoices.delete')->only(['destroy', 'item_destroy']);
    }

    public function index()
    {
        $invoices = Invoice::select('id', 'invoice_number', 'date', 'client_id', 'currency_id', 'shipment_id')->filter()->orderBy('id', 'desc')->paginate(25);
        $clients = Client::select('id', 'name')->get();
        $shipments = Shipment::select('id', 'shipment_number')->get();

        $data = compact('invoices', 'clients', 'shipments');
        return view('invoices.index', $data);
    }

    public function new()
    {
        $clients = Client::select('id', 'name', 'tax_id')->get();
        $items = Item::select('id', 'name', 'unit_price', 'unit', 'type')->get();
        $taxes = Tax::select('id', 'name', 'rate')->get();
        $suppliers = Supplier::select('id', 'name')->get();
        $currencies = Helper::get_currencies();
        $shipments = Shipment::select('id', 'shipment_number')->get();

        $data = compact('clients', 'items', 'taxes', 'suppliers', 'currencies', 'shipments');
        return view('invoices.new', $data);
    }

    public function create(Request $request)
    {
        $request->validate([
            'invoice_number' => 'required|string|max:255|unique:invoices,invoice_number',
            'client_id' => 'required|exists:clients,id',
            'shipment_id' => 'required|exists:shipments,id',
            'tax_id' => 'required|exists:taxes,id',
            'currency_id' => 'required|exists:currencies,id',
            'date' => 'required|date',
            'item_id.*' => 'required|exists:items,id',
            'description.*' => 'required',
            'quantity.*' => 'required|numeric|min:1',
            'unit_price.*' => 'required|numeric|min:0',
            'supplier_id.*' => 'nullable|exists:suppliers,id',
            'tax.*' => 'required',
        ]);

        // $number = Invoice::generate_number();

        // Create Invoice
        $invoice = Invoice::create([
            'invoice_number' => $request->invoice_number,
            'client_id' => $request->client_id,
            'shipment_id' => $request->shipment_id,
            'tax_id' => $request->tax_id,
            'currency_id' => $request->currency_id,
            'date' => $request->date,
            'type' => 'invoice',
            'sales_order_id' => $request->sales_order_id ?? null,
        ]);

        $total_price = 0;
        $total_tax = 0;
        $total_after_tax = 0;
        $transactionsString = '';

        $tax_rate = $invoice->tax->rate / 100;

        foreach ($request->item_id as $key => $itemId) {
            $quantity = $request->quantity[$key];
            $unit_price = $request->unit_price[$key];
            $supplier_id = $request->supplier_id[$key] ?? null;

            $line_total = $quantity * $unit_price;

            if (isset($request->tax[$key])) {
                $line_tax = $line_total * $tax_rate;
                $line_total_after_tax = $line_total + $line_tax;
            } else {
                $line_tax = 0;
                $line_total_after_tax = $line_total;
            }

            InvoiceItem::create([
                'invoice_id' => $invoice->id,
                'item_id' => $itemId,
                'supplier_id' => $supplier_id,
                'description' => $request->description[$key],
                'type' => $supplier_id ? 'expense' : 'item',
                'quantity' => $quantity,
                'unit_price' => $unit_price,
                'total_price' => $line_total,
                'vat' => $line_tax,
                'total_price_after_vat' => $line_total_after_tax,
            ]);

            if ($supplier_id) {
                // Supplier Payable Transaction
                $supplier_account = Supplier::find($supplier_id)->payable_account;
                $transaction = Transaction::create([
                    'user_id' => auth()->id(),
                    'account_id' => $supplier_account->id,
                    'supplier_id' => $supplier_id,
                    'currency_id' => $invoice->currency_id,
                    'debit' => 0,
                    'credit' => $line_total_after_tax,
                    'balance' => -$line_total_after_tax,
                    'title' => 'Supplier Payable',
                    'description' => "Payable recorded for supplier on Invoice {$invoice->invoice_number}",
                ]);
                $transactionsString .= "{$transaction->id}|";

                // Expense Transaction
                $expense_account = Account::findOrFail(Variable::where('title', 'expense_account')->first()->value);
                $transaction = Transaction::create([
                    'user_id' => auth()->id(),
                    'account_id' => $expense_account->id,
                    'currency_id' => $invoice->currency_id,
                    'debit' => $line_total_after_tax,
                    'credit' => 0,
                    'balance' => $line_total_after_tax,
                    'title' => 'Expense Recorded',
                    'description' => "Expense recorded for supplier on Invoice {$invoice->invoice_number}",
                ]);
                $transactionsString .= "{$transaction->id}|";
            } else {
                $total_price += $line_total;
                $total_tax += $line_tax;
                $total_after_tax += $line_total_after_tax;
            }
        }

        if ($total_tax != 0) {
            // Tax Payable Transaction
            $transaction = Transaction::create([
                'user_id' => auth()->id(),
                'account_id' => $invoice->tax->account->id,
                'currency_id' => $invoice->currency_id,
                'debit' => 0,
                'credit' => $total_tax,
                'balance' => -$total_tax,
                'title' => 'Tax Payable',
                'description' => "Tax payable recorded for Invoice {$invoice->invoice_number}",
            ]);
            $transactionsString .= "{$transaction->id}|";
        }

        // Client Receivable Transaction
        $receivable_account = $invoice->client->receivable_account;
        $transaction = Transaction::create([
            'user_id' => auth()->id(),
            'account_id' => $receivable_account->id,
            'client_id' => $invoice->client_id,
            'currency_id' => $invoice->currency_id,
            'debit' => $total_after_tax,
            'credit' => 0,
            'balance' => $total_after_tax,
            'title' => 'Client Receivable',
            'description' => "Receivable recorded for client on Invoice {$invoice->invoice_number}",
        ]);
        $transactionsString .= "{$transaction->id}|";

        // Revenue Transaction
        $revenue_account = Account::findOrFail(Variable::where('title', 'revenue_account')->first()->value);
        $transaction = Transaction::create([
            'user_id' => auth()->id(),
            'account_id' => $revenue_account->id,
            'currency_id' => $invoice->currency_id,
            'debit' => 0,
            'credit' => $total_after_tax + $total_tax,
            'balance' => -$total_after_tax + $total_tax,
            'title' => 'Revenue Recorded',
            'description' => "Revenue recorded for Invoice {$invoice->invoice_number}",
        ]);
        $transactionsString .= "{$transaction->id}|";

        $invoice->update([
            'transactions' => $transactionsString,
        ]);

        Log::create([
            'text' => auth()->user()->name . " created Invoice " . $invoice->invoice_number . " on " . now(),
        ]);

        return redirect()->route('invoices')->with('success', 'Invoice created successfully.');
    }

    public function edit(Invoice $invoice)
    {
        $items = Item::select('id', 'name', 'unit_price', 'type')->get();
        $suppliers = Supplier::select('id', 'name')->get();
        $invoice_items = $invoice->items;

        $data = compact('invoice', 'items', 'suppliers', 'invoice_items');
        return view('invoices.edit', $data);
    }

    public function update(Invoice $invoice, Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'item_id.*' => 'nullable|exists:items,id',
            'description.*' => 'nullable',
            'quantity.*' => 'nullable|numeric|min:1',
            'unit_price.*' => 'nullable|numeric|min:0',
            'supplier_id.*' => 'nullable|exists:suppliers,id',
            'tax.*' => 'nullable',
        ]);

        $invoice->update([
            'date' => $request->date,
        ]);

        if ($request->item_id[0] != null) {
            $total_price = 0;
            $total_tax = 0;
            $total_after_tax = 0;
            $transactionsString = $invoice->transactions;

            $tax_rate = $invoice->tax->rate / 100;

            foreach ($request->item_id as $key => $itemId) {
                $quantity = $request->quantity[$key];
                $unit_price = $request->unit_price[$key];
                $supplier_id = $request->supplier_id[$key] ?? null;

                $line_total = $quantity * $unit_price;

                if (isset($request->tax[$key])) {
                    $line_tax = $line_total * $tax_rate;
                    $line_total_after_tax = $line_total + $line_tax;
                } else {
                    $line_tax = 0;
                    $line_total_after_tax = $line_total;
                }

                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'item_id' => $itemId,
                    'supplier_id' => $supplier_id,
                    'description' => $request->description[$key],
                    'type' => $supplier_id ? 'expense' : 'item',
                    'quantity' => $quantity,
                    'unit_price' => $unit_price,
                    'total_price' => $line_total,
                    'vat' => $line_tax,
                    'total_price_after_vat' => $line_total_after_tax,
                ]);

                if ($supplier_id) {
                    // Supplier Payable Transaction
                    $supplier_account = Supplier::find($supplier_id)->payable_account;
                    $transaction = Transaction::create([
                        'user_id' => auth()->id(),
                        'account_id' => $supplier_account->id,
                        'supplier_id' => $supplier_id,
                        'currency_id' => $invoice->currency_id,
                        'debit' => 0,
                        'credit' => $line_total_after_tax,
                        'balance' => -$line_total_after_tax,
                        'title' => 'Supplier Payable',
                        'description' => "Payable recorded for supplier on Invoice {$invoice->invoice_number}",
                    ]);
                    $transactionsString .= "{$transaction->id}|";

                    // Expense Transaction
                    $expense_account = Account::findOrFail(Variable::where('title', 'expense_account')->first()->value);
                    $transaction = Transaction::create([
                        'user_id' => auth()->id(),
                        'account_id' => $expense_account->id,
                        'currency_id' => $invoice->currency_id,
                        'debit' => $line_total_after_tax,
                        'credit' => 0,
                        'balance' => $line_total_after_tax,
                        'title' => 'Expense Recorded',
                        'description' => "Expense recorded for supplier on Invoice {$invoice->invoice_number}",
                    ]);
                    $transactionsString .= "{$transaction->id}|";
                } else {
                    $total_price += $line_total;
                    $total_tax += $line_tax;
                    $total_after_tax += $line_total_after_tax;
                }
            }

            if ($total_tax != 0) {
                // Tax Payable Transaction
                $transaction = Transaction::create([
                    'user_id' => auth()->id(),
                    'account_id' => $invoice->tax->account->id,
                    'currency_id' => $invoice->currency_id,
                    'debit' => 0,
                    'credit' => $total_tax,
                    'balance' => -$total_tax,
                    'title' => 'Tax Payable',
                    'description' => "Tax payable recorded for Invoice {$invoice->invoice_number}",
                ]);
                $transactionsString .= "{$transaction->id}|";
            }

            // Client Receivable Transaction
            $receivable_account = $invoice->client->receivable_account;
            $transaction = Transaction::create([
                'user_id' => auth()->id(),
                'account_id' => $receivable_account->id,
                'client_id' => $invoice->client_id,
                'currency_id' => $invoice->currency_id,
                'debit' => $total_after_tax,
                'credit' => 0,
                'balance' => $total_after_tax,
                'title' => 'Client Receivable',
                'description' => "Receivable recorded for client on Invoice {$invoice->invoice_number}",
            ]);
            $transactionsString .= "{$transaction->id}|";

            // Revenue Transaction
            $revenue_account = Account::findOrFail(Variable::where('title', 'revenue_account')->first()->value);
            $transaction = Transaction::create([
                'user_id' => auth()->id(),
                'account_id' => $revenue_account->id,
                'currency_id' => $invoice->currency_id,
                'debit' => 0,
                'credit' => $total_after_tax + $total_tax,
                'balance' => -$total_after_tax + $total_tax,
                'title' => 'Revenue Recorded',
                'description' => "Revenue recorded for Invoice {$invoice->invoice_number}",
            ]);
            $transactionsString .= "{$transaction->id}|";

            $invoice->update([
                'transactions' => $transactionsString,
            ]);
        }

        $text = ucwords(auth()->user()->name) . ' updated Invoice ' . $invoice->invoice_number . ", datetime :   " . now();
        Log::create(['text' => $text]);

        return redirect()->back()->with('warning', 'Invoice updated successfully!');
    }

    public function show(Invoice $invoice)
    {
        $items = $invoice->items;
        $shipment = $invoice->shipment;

        $total = 0;
        $vat = 0;
        $total_price_after_vat = 0;

        foreach ($items as $item) {
            if ($item->type == 'item') {
                $total += $item->total_price;
                $vat += $item->vat;
                $total_price_after_vat += $item->total_price_after_vat;
            }
        }

        $data = compact('invoice', 'items', 'shipment', 'total', 'vat', 'total_price_after_vat');
        return view('invoices.show', $data);
    }

    public function items(Invoice $invoice)
    {
        $items = $invoice->items;

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
        if ($invoice->can_delete()) {
            $text = ucwords(auth()->user()->name) . " deleted Invoice : " . $invoice->invoice_number . ", datetime :   " . now();

            foreach ($invoice->items as $item) {
                $item->delete();
            }

            if ($invoice->transactions) {
                foreach (explode('|', $invoice->transactions) as $id) {
                    if ($id != '') {
                        Transaction::find($id)->delete();
                    }
                }
            }

            Log::create(['text' => $text]);
            $invoice->delete();

            return redirect()->back()->with('error', 'Invoice deleted successfully!');
        } else {
            return redirect()->back()->with('error', 'Unable to delete...');
        }
    }

    public function item_destroy(InvoiceItem $invoice_item)
    {
        $invoice_item->delete();

        return redirect()->back()->with('success', 'Invoice Item deleted successfully!');
    }
}
