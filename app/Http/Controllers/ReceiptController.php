<?php

namespace App\Http\Controllers;

use App\Models\BarcodeItem;
use App\Models\Item;
use App\Models\JournalVoucher;
use App\Models\Log;
use App\Models\Receipt;
use App\Models\ReceiptItem;
use App\Models\LandedCost;
use App\Models\Supplier;
use App\Models\Tax;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;

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
        $receipts = Receipt::select('id', 'receipt_number', 'supplier_invoice', 'date', 'supplier_id', 'tax_id', 'currency_id', 'foreign_currency_id', 'journal_voucher_id')->filter()->orderBy('id', 'desc')->paginate(25);
        $suppliers = Supplier::select('id', 'name')->get();
        $taxes = Tax::select('id', 'name')->get();

        $data = compact('receipts', 'suppliers', 'taxes');
        return view('receipts.index', $data);
    }

    public function new()
    {
        $suppliers = Supplier::select('id', 'name', 'tax_id')->get();
        $items = Item::select('id', 'itemcode', 'type')->get();
        $taxes = Tax::select('id', 'name', 'rate')->get();
        $data = compact('suppliers', 'items', 'taxes');

        return view('receipts.new', $data);
    }

    public function create(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'supplier_invoice' => 'required|string|max:255|unique:receipts',
            'tax_id' => 'required|exists:taxes,id',
            'currency_id' => 'required|exists:currencies,id',
            'foreign_currency_id' => 'required|exists:currencies,id',
            'rate' => 'required|numeric|min:0',
            'date' => 'required|date',
            'item_id.*' => 'required|exists:items,id',
            'quantity.*' => 'required|numeric',
            'unit_cost.*' => 'required|numeric',
        ]);

        $number = Receipt::generate_number();

        // Create automatic JV
        $jv = JournalVoucher::create([
            'user_id' => auth()->user()->id,
            'currency_id' => $request->input('currency_id'),
            'foreign_currency_id' => $request->input('foreign_currency_id'),
            'rate' => $request->input('rate'),
            'date' => $request->input('date'),
            'description' => 'Receipt ' . $number . ', automatically generated by system...',
            'status' => 'unposted',
            'source' => 'system',
            'batch' => 'S',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $receipt = Receipt::create([
            'journal_voucher_id' => $jv->id,
            'receipt_number' => $number,
            'supplier_id' => $request->input('supplier_id'),
            'supplier_invoice' => $request->input('supplier_invoice'),
            'tax_id' => $request->input('tax_id'),
            'currency_id' => $request->input('currency_id'),
            'foreign_currency_id' => $request->input('foreign_currency_id'),
            'rate' => $request->input('rate'),
            'date' => $request->input('date'),
            'type' => 'receipt',
            'po_id' => $request->input('po_id'),
        ]);

        $total_item_cost = 0;
        $total_tax = 0;
        $total_cost_after_vat = 0;
        $total_landed_cost = 0;
        $rate = $request->input('rate') ?? 0;

        // Calculate total item costs with VAT
        $tax_rate = Tax::find($request->input('tax_id'))->rate / 100;
        $items = [];
        foreach ($request->input('item_id') as $key => $itemId) {
            $quantity = $request->input('quantity')[$key];
            $unit_cost = $request->input('unit_cost')[$key];
            $total_cost = $unit_cost * $quantity;
            $vat = $total_cost * $tax_rate;
            $total_cost_with_vat = $total_cost + $vat;

            $total_item_cost += $total_cost;
            $total_tax += $vat;
            $total_cost_after_vat += $total_cost_with_vat;

            $items[] = [
                'item_id' => $itemId,
                'quantity' => $quantity,
                'unit_cost' => $unit_cost,
                'total_cost' => $total_cost,
                'vat' => $vat,
                'total_cost_with_vat' => $total_cost_with_vat,
            ];
        }

        if ($request->input('name')[0] != null) {
            // Calculate total landed cost
            foreach ($request->input('name') as $key => $name) {
                $amount = $request->input('amount')[$key];
                $total_landed_cost += $amount;

                LandedCost::create([
                    'receipt_id' => $receipt->id,
                    'name' => $name,
                    'supplier_id' => $request->input('landed_cost_supplier_id')[$key],
                    'currency_id' => $request->input('landed_cost_currency_id')[$key],
                    'amount' => $amount,
                    'rate' => $rate,
                    'date' => $request->input('landed_cost_date')[$key],
                ]);

                // Create landed cost supplier credit transaction
                $supplier_lc = Supplier::find($request->input('landed_cost_supplier_id')[$key]);
                Transaction::create([
                    'user_id' => auth()->user()->id,
                    'journal_voucher_id' => $jv->id,
                    'account_id' => $supplier_lc->payable_account_id,
                    'supplier_id' => $supplier_lc->id,
                    'currency_id' => $receipt->currency_id,
                    'debit' => 0,
                    'credit' => $amount,
                    'balance' => 0 - $amount,
                    'foreign_currency_id' => $receipt->foreign_currency_id,
                    'rate' => $rate,
                    'foreign_debit' => 0,
                    'foreign_credit' => $amount * $rate,
                    'foreign_balance' => 0 - ($amount * $rate),
                ]);
            }
        }

        // Distribute landed cost across items
        foreach ($items as $key => $item) {
            $proportion = $item['total_cost_with_vat'] / $total_cost_after_vat;
            $landed_cost_allocation = $total_landed_cost * $proportion;
            $total_after_landed_cost = $item['total_cost_with_vat'] + $landed_cost_allocation;
            $unit_price_with_landed_cost = $total_after_landed_cost / $item['quantity'];

            ReceiptItem::create([
                'receipt_id' => $receipt->id,
                'item_id' => $item['item_id'],
                'quantity' => $item['quantity'],
                'unit_cost' => $item['unit_cost'],
                'total_cost' => $item['total_cost'],
                'vat' => $item['vat'],
                'rate' => $rate,
                'total_cost_after_vat' => $item['total_cost_with_vat'],
                'total_after_landed_cost' => $total_after_landed_cost,
                'total_foreign_cost' => $item['total_cost'] * $rate,
            ]);

            $item_model = Item::find($item['item_id']);
            $item_model->update_unit_cost($unit_price_with_landed_cost);
        }

        // Create inventory debit transaction
        $inventory_account = Item::find($items[0]['item_id'])->inventory_account;
        Transaction::create([
            'user_id' => auth()->user()->id,
            'journal_voucher_id' => $jv->id,
            'account_id' => $inventory_account->id,
            'currency_id' => $receipt->currency_id,
            'debit' => $total_cost_after_vat - $total_tax + $total_landed_cost,
            'credit' => 0,
            'balance' => $total_cost_after_vat - $total_tax + $total_landed_cost,
            'foreign_currency_id' => $receipt->foreign_currency_id,
            'rate' => $rate,
            'foreign_debit' => ($total_cost_after_vat - $total_tax + $total_landed_cost) * $rate,
            'foreign_credit' => 0,
            'foreign_balance' => ($total_cost_after_vat - $total_tax + $total_landed_cost) * $rate,
        ]);

        // Create tax debit transaction
        $tax_account = Tax::find($request->input('tax_id'))->account;
        Transaction::create([
            'user_id' => auth()->user()->id,
            'journal_voucher_id' => $jv->id,
            'account_id' => $tax_account->id,
            'currency_id' => $receipt->currency_id,
            'debit' => $total_tax,
            'credit' => 0,
            'balance' => $total_tax,
            'foreign_currency_id' => $receipt->foreign_currency_id,
            'rate' => $rate,
            'foreign_debit' => $total_tax * $rate,
            'foreign_credit' => 0,
            'foreign_balance' => $total_tax * $rate,
        ]);

        // Create supplier credit transaction
        $supplier = Supplier::find($request->input('supplier_id'));
        Transaction::create([
            'user_id' => auth()->user()->id,
            'journal_voucher_id' => $jv->id,
            'account_id' => $supplier->payable_account_id,
            'supplier_id' => $supplier->id,
            'currency_id' => $receipt->currency_id,
            'debit' => 0,
            'credit' => $total_item_cost + $total_tax,
            'balance' => 0 - ($total_item_cost + $total_tax),
            'foreign_currency_id' => $receipt->foreign_currency_id,
            'rate' => $rate,
            'foreign_debit' => 0,
            'foreign_credit' => ($total_item_cost + $total_tax) * $rate,
            'foreign_balance' => 0 - (($total_item_cost + $total_tax) * $rate),
        ]);

        // Handle serialized items barcodes
        if ($request->receipt_barcode_excel) {
            $the_file = $request->file('receipt_barcode_excel');
            $spreadsheet = IOFactory::load($the_file->getRealPath());
            $sheet = $spreadsheet->getActiveSheet();
            $row_limit = $sheet->getHighestDataRow();
            $row_range = range(2, $row_limit);

            $counter = 0;
            foreach ($row_range as $row) {
                $item = Item::where('name', $sheet->getCell('A' . $row)->getValue())->first();

                BarcodeItem::create([
                    'item_id' => $item->id,
                    'receipt_id' => $receipt->id,
                    'barcode' => $sheet->getCell('B' . $row)->getValue(),
                    'created_at' => Carbon::now()->addSeconds($counter),
                ]);
                $counter++;
            }
        } else if ($request->barcodes) {
            foreach ($request->barcodes as $itemId => $row) {
                foreach ($row as $barcode) {
                    BarcodeItem::create([
                        'item_id' => $itemId,
                        'receipt_id' => $receipt->id,
                        'barcode' => $barcode,
                    ]);
                }
            }
        }

        $text = ucwords(auth()->user()->name) . " created new Receipt : " . $receipt->receipt_number . ", datetime :   " . now();
        Log::create(['text' => $text]);

        return redirect()->route('receipts')->with('success', 'Receipt created successfully!');
    }

    public function edit(Receipt $receipt)
    {
        if ($receipt->can_edit()) {
            $items = Item::select('id', 'itemcode')->get();
            $taxes = Tax::select('id', 'name', 'rate')->get();
            $suppliers = Supplier::select('id', 'name')->get();

            $total = 0;
            $total_foreign = 0;
            $total_after_tax = 0;
            $total_tax = 0;
            $total_landed_cost = 0;

            foreach ($receipt->receipt_items as $item) {
                $total += $item->total_cost;
                $total_tax += $item->vat;
                $total_foreign += $item->total_foreign_cost;
                $total_after_tax += $item->total_cost_after_vat;
            }

            foreach ($receipt->landed_costs as $lc) {
                $total_landed_cost += $lc->amount;
            }

            $data = compact('receipt', 'items', 'taxes', 'suppliers', 'total', 'total_foreign', 'total_after_tax', 'total_landed_cost', 'total_tax');

            return view('receipts.edit', $data);
        } else {
            return redirect()->back()->with('Unable to edit...');
        }
    }

    public function update(Receipt $receipt, Request $request)
    {
        if ($receipt->can_edit()) {
            $request->validate([
                'supplier_invoice' => 'required|string|max:255',
                'tax_id' => 'required|exists:taxes,id',
                'currency_id' => 'required|exists:currencies,id',
                'foreign_currency_id' => 'required|exists:currencies,id',
                'date' => 'required|date',
            ]);

            $jv = $receipt->journal_voucher;

            $receipt->update([
                'supplier_invoice' => $request->input('supplier_invoice'),
                'tax_id' => $request->input('tax_id'),
                'currency_id' => $request->input('currency_id'),
                'foreign_currency_id' => $request->input('foreign_currency_id'),
                'date' => $request->input('date'),
            ]);

            $total = 0;
            $total_lc = 0;
            $total_tax = 0;
            $total_landed_cost = 0;
            $rate = $request->input('rate') ?? 0;

            if ($request->input('name')[0] != null) {
                // create landed cost and get total
                foreach ($request->input('name') as $key => $name) {
                    LandedCost::create([
                        'receipt_id' => $receipt->id,
                        'name' => $name,
                        'supplier_id' => $request->input('landed_cost_supplier_id')[$key],
                        'currency_id' => $request->input('landed_cost_currency_id')[$key],
                        'amount' => $request->input('amount')[$key],
                        'rate' => $rate,
                        'date' => $request->input('landed_cost_date')[$key],
                    ]);

                    $total_landed_cost += $request->input('amount')[$key];
                }
            }

            $tax_rate = Tax::find($request->input('tax_id'))->rate / 100;
            if ($request->input('item_id')[0] != null) {
                foreach ($request->input('item_id') as $key => $itemId) {
                    $original_unit_cost = $request->input('unit_cost')[$key];
                    $t = $original_unit_cost * $request->input('quantity')[$key];
                    $total += $t;

                    $vat = $t * $tax_rate;
                    $total_tax += $vat;
                }

                foreach ($request->input('item_id') as $key => $itemId) {
                    $original_unit_cost = $request->input('unit_cost')[$key];
                    $t = $original_unit_cost * $request->input('quantity')[$key];

                    $vat = $t * $tax_rate;
                    $total_cost_after_vat = $t + $vat;

                    $landed_cost_per_item = ($original_unit_cost / $total) * $total_landed_cost;

                    $total_after_landed_cost = $total_cost_after_vat + $landed_cost_per_item;
                    $total_lc += ($total_after_landed_cost - $vat);
                    $unit_cost = $total_after_landed_cost / $request->input('quantity')[$key];

                    ReceiptItem::create([
                        'receipt_id' => $receipt->id,
                        'item_id' => $itemId,
                        'quantity' => $request->input('quantity')[$key],
                        'unit_cost' => $original_unit_cost,
                        'total_cost' => $t,
                        'vat' => $vat,
                        'rate' => $rate,
                        'total_cost_after_vat' => $total_cost_after_vat,
                        'total_after_landed_cost' => $total_after_landed_cost,
                        'total_foreign_cost' => $t * $rate,
                    ]);

                    $item = Item::find($itemId);
                    $item->update_unit_cost($unit_cost);
                }
            }

            // create inventory debit transaction
            if ($total_lc != 0) {
                $inventory_account = Item::find($itemId)->inventory_account;
                Transaction::create([
                    'user_id' => auth()->user()->id,
                    'journal_voucher_id' => $jv->id,
                    'account_id' => $inventory_account->id,
                    'currency_id' => $receipt->currency_id,
                    'debit' => $total_lc,
                    'credit' => 0,
                    'balance' => $total_lc,
                    'foreign_currency_id' => $receipt->foreign_currency_id,
                    'rate' => $rate,
                    'foreign_debit' => $total_lc * $rate,
                    'foreign_credit' => 0,
                    'foreign_balance' => $total_lc * $rate,
                ]);
            }

            // create tax debit transaction
            if ($total_tax != 0) {
                $account = Tax::find($request->input('tax_id'))->account;
                Transaction::create([
                    'user_id' => auth()->user()->id,
                    'journal_voucher_id' => $jv->id,
                    'account_id' => $account->id,
                    'currency_id' => $receipt->currency_id,
                    'debit' => $total_tax,
                    'credit' => 0,
                    'balance' => $total_tax,
                    'foreign_currency_id' => $receipt->foreign_currency_id,
                    'rate' => $rate,
                    'foreign_debit' => $total_tax * $rate,
                    'foreign_credit' => 0,
                    'foreign_balance' => $total_tax * $rate,
                ]);
            }

            // create supplier credit transaction
            if (($total_lc + $total_tax) != 0) {
                $supplier = $receipt->supplier;
                Transaction::create([
                    'user_id' => auth()->user()->id,
                    'journal_voucher_id' => $jv->id,
                    'account_id' => $supplier->payable_account_id,
                    'suppler_id' => $supplier->id,
                    'currency_id' => $receipt->currency_id,
                    'debit' => 0,
                    'credit' => $total_lc + $total_tax,
                    'balance' => 0 - ($total_lc + $total_tax),
                    'foreign_currency_id' => $receipt->foreign_currency_id,
                    'rate' => $rate,
                    'foreign_debit' => 0,
                    'foreign_credit' => ($total_lc + $total_tax) * $rate,
                    'foreign_balance' => 0 - (($total_lc + $total_tax) * $rate),
                ]);
            }

            $text = ucwords(auth()->user()->name) . ' updated Receipt ' . $receipt->receipt_number . ", datetime :   " . now();
            Log::create(['text' => $text]);

            return redirect()->back()->with('warning', 'Receipt updated successfully!');
        } else {
            return redirect()->back()->with('Unable to edit...');
        }
    }

    public function show(Receipt $receipt)
    {
        $total = 0;
        $total_tax = 0;
        $total_foreign = 0;
        $total_after_tax = 0;
        $total_after_landed_cost = 0;
        $total_landed_cost = 0;

        foreach ($receipt->receipt_items as $item) {
            $total += $item->total_cost;
            $total_tax += $item->vat;
            $total_foreign += $item->total_foreign_cost;
            $total_after_tax += $item->total_cost_after_vat;
            $total_after_landed_cost += $item->total_after_landed_cost;
        }

        foreach ($receipt->landed_costs as $lc) {
            $total_landed_cost += $lc->amount;
        }

        $data = compact('receipt', 'total', 'total_tax', 'total_foreign', 'total_after_tax', 'total_after_landed_cost', 'total_landed_cost');
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

        // create automatic JV
        $jv = JournalVoucher::create([
            'user_id' => auth()->user()->id,
            'currency_id' => $old_receipt->currency_id,
            'foreign_currency_id' => $old_receipt->foreign_currency_id,
            'rate' => $old_receipt->rate,
            'date' => date('Y-m-d'),
            'description' => 'Return Receipt for ' . $old_receipt->receipt_number . ', automatically generated by system...',
            'status' => 'unposted',
            'source' => 'system',
            'batch' => 'S',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $receipt = Receipt::create([
            'journal_voucher_id' => $jv->id,
            'receipt_number' => $return_number,
            'supplier_id' => $old_receipt->supplier_id,
            'supplier_invoice' => $old_receipt->supplier_invoice,
            'tax_id' => $old_receipt->tax_id,
            'currency_id' => $old_receipt->currency_id,
            'foreign_currency_id' => $old_receipt->foreign_currency_id,
            'rate' => $old_receipt->rate,
            'date' => date('Y-m-d'),
            'type' => 'return',
        ]);

        $total = 0;
        $total_lc = 0;
        $total_tax = 0;
        $total_landed_cost = 0;
        $rate = $old_receipt->rate ?? 0;

        // create landed cost and get total
        foreach ($request->landed_costs as $index => $lc) {
            if (isset($lc['id'])) {
                $old_lc = LandedCost::find($lc['id']);

                LandedCost::create([
                    'receipt_id' => $receipt->id,
                    'name' => $old_lc->name,
                    'supplier_id' => $old_lc->supplier_id,
                    'currency_id' => $old_lc->currency_id,
                    'amount' => $lc['amount'],
                    'rate' => $rate,
                    'date' => $old_lc->date,
                ]);

                // create landed cost supplier credit transaction
                $old_lc_supplier = $old_lc->supplier;
                Transaction::create([
                    'user_id' => auth()->user()->id,
                    'journal_voucher_id' => $jv->id,
                    'account_id' => $old_lc_supplier->payable_account_id,
                    'supplier_id' => $old_lc_supplier->id,
                    'currency_id' => $receipt->currency_id,
                    'debit' => $lc['amount'],
                    'credit' => 0,
                    'balance' => $lc['amount'],
                    'foreign_currency_id' => $receipt->foreign_currency_id,
                    'rate' => $rate,
                    'foreign_debit' => $lc['amount'] * $rate,
                    'foreign_credit' => 0,
                    'foreign_balance' => $lc['amount'] * $rate,
                ]);

                $total_landed_cost += $lc['amount'];
            }
        }

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
                    'rate' => $rate,
                    'total_cost_after_vat' => $total_cost_after_vat,
                    'total_after_landed_cost' => $total_after_landed_cost,
                    'total_foreign_cost' => $t * $rate,
                ]);


                $old_receipt_item->item->update_unit_cost($unit_cost);
            }
        }

        // create inventory credit transaction
        $inventory_account = $old_receipt_item->item->inventory_account;
        Transaction::create([
            'user_id' => auth()->user()->id,
            'journal_voucher_id' => $jv->id,
            'account_id' => $inventory_account->id,
            'currency_id' => $receipt->currency_id,
            'debit' => 0,
            'credit' => $total_lc,
            'balance' => 0 - $total_lc,
            'foreign_currency_id' => $receipt->foreign_currency_id,
            'rate' => $rate,
            'foreign_debit' => 0,
            'foreign_credit' => $total_lc * $rate,
            'foreign_balance' => 0 - ($total_lc * $rate),
        ]);

        // create tax credit transaction
        $account = $old_receipt->tax->account;
        Transaction::create([
            'user_id' => auth()->user()->id,
            'journal_voucher_id' => $jv->id,
            'account_id' => $account->id,
            'currency_id' => $receipt->currency_id,
            'debit' => 0,
            'credit' => $total_tax,
            'balance' => 0 - $total_tax,
            'foreign_currency_id' => $receipt->foreign_currency_id,
            'rate' => $rate,
            'foreign_debit' => 0,
            'foreign_credit' => $total_tax * $rate,
            'foreign_balance' => 0 - ($total_tax * $rate),
        ]);

        // create supplier credit transaction
        $supplier = $old_receipt->supplier;
        Transaction::create([
            'user_id' => auth()->user()->id,
            'journal_voucher_id' => $jv->id,
            'account_id' => $supplier->payable_account_id,
            'supplier_id' => $supplier->id,
            'currency_id' => $receipt->currency_id,
            'debit' => $total_lc + $total_tax - $total_landed_cost,
            'credit' => 0,
            'balance' => $total_lc + $total_tax - $total_landed_cost,
            'foreign_currency_id' => $receipt->foreign_currency_id,
            'rate' => $rate,
            'foreign_debit' => ($total_lc + $total_tax - $total_landed_cost) * $rate,
            'foreign_credit' => 0,
            'foreign_balance' => ($total_lc + $total_tax - $total_landed_cost) * $rate,
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

    public function landed_costs(Receipt $receipt)
    {
        $lcs = $receipt->landed_costs;

        $customizedResult = [];
        $index = 0;
        foreach ($lcs as $lc) {
            $customizedResult = [
                'id' => $lc->id,
                'name' => $lc->name,
                'amount' => $lc->amount,
            ];
            $customizedResults[] = $customizedResult;
            $index++;
        }

        return response()->json($customizedResults);
    }

    public function destroy(Receipt $receipt)
    {
        if ($receipt->can_delete()) {
            $text = ucwords(auth()->user()->name) . " deleted Receipt : " . $receipt->receipt_number . ", datetime :   " . now();

            Log::create(['text' => $text]);
            $receipt->delete();

            return redirect()->back()->with('error', 'Receipt deleted successfully!');
        } else {
            return redirect()->back()->with('error', 'Unothorized Access...');
        }
    }
}
