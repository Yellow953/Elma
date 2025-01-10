<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\CDNote;
use App\Models\CDNoteItem;
use App\Models\Supplier;
use App\Models\Log;
use App\Models\Tax;
use App\Models\Transaction;
use Illuminate\Http\Request;

class DebitNoteController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:debit_notes.read')->only('index');
        $this->middleware('permission:debit_notes.create')->only(['new', 'create']);
        $this->middleware('permission:debit_notes.update')->only(['edit', 'update']);
        $this->middleware('permission:debit_notes.delete')->only('destroy');
        $this->middleware('permission:debit_notes.export')->only('export');
    }

    public function index()
    {
        $cdnotes = CDNote::select('id', 'cdnote_number', 'supplier_id', 'type', 'date')->where('type', 'debit note')->filter()->orderBy('id', 'desc')->paginate(25);
        $suppliers = Supplier::select('id', 'name')->get();
        $data = compact('cdnotes', 'suppliers');

        return view('debit_notes.index', $data);
    }

    public function new()
    {
        $suppliers = Supplier::select('id', 'name', 'tax_id')->get();
        $accounts = Account::select('id', 'account_number', 'account_description')->get();

        $data = compact('suppliers', 'accounts');

        return view('debit_notes.new', $data);
    }

    public function create(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'currency_id' => 'required|exists:currencies,id',
            'description' => 'required|string',
            'date' => 'required|date',
            'tax_id' => 'required',
            'account_id.*' => 'required|exists:accounts,id',
            'amount.*' => 'required|numeric',
        ]);

        $number = CDNote::generate_number('debit note');

        $cdnote = CDNote::create([
            'cdnote_number' => $number,
            'supplier_id' => $request->supplier_id,
            'currency_id' => $request->currency_id,
            'type' => 'debit note',
            'description' => $request->description,
            'date' => $request->date,
            'tax_id' => $request->tax_id,
        ]);

        $total = 0;
        $total_tax = 0;

        $tax = Tax::find($request->tax_id);

        foreach ($request->input('account_id') as $key => $accountId) {
            $amount = $request->input('amount')[$key];
            $total += $amount;

            CDNoteItem::create([
                'cdnote_id' => $cdnote->id,
                'account_id' => $accountId,
                'amount' => $amount,
                'tax' => $amount * $tax->rate / 100,
            ]);

            $total_tax += $amount * $tax->rate / 100;

            // Account Credit transaction
            Transaction::create([
                'user_id' => auth()->user()->id,
                'account_id' => $accountId,
                'currency_id' => $cdnote->currency_id,
                'debit' => 0,
                'credit' => $amount,
                'balance' => 0 - $amount,
            ]);
        }

        if ($total_tax != 0) {
            // Tax Credit transaction
            Transaction::create([
                'user_id' => auth()->user()->id,
                'account_id' => $tax->account_id,
                'currency_id' => $cdnote->currency_id,
                'debit' => 0,
                'credit' => $total_tax,
                'balance' => 0 - $total_tax,
            ]);
        }

        // Supplier Debit transaction
        $supplier = Supplier::find($request->supplier_id);
        Transaction::create([
            'user_id' => auth()->user()->id,
            'account_id' => $supplier->payable_account_id,
            'supplier_id' => $supplier->id,
            'currency_id' => $cdnote->currency_id,
            'debit' => ($total + $total_tax),
            'credit' => 0,
            'balance' => ($total + $total_tax),
        ]);

        $text = ucwords(auth()->user()->name) . " created new Debit Note : " . $cdnote->cdnote_number . ", datetime :   " . now();
        Log::create(['text' => $text]);

        return redirect()->route('debit_notes')->with('success', 'Debit Note created successfully!');
    }

    public function edit(CDNote $cdnote)
    {
        $accounts = Account::select('id', 'account_number', 'account_description')->get();

        $total = 0;
        $total_tax = 0;
        $total_after_tax = 0;
        foreach ($cdnote->cdnote_items as $item) {
            $total += $item->amount;
            $total_tax += $item->tax;
            $total_after_tax += $item->tax;
        }

        $data = compact('cdnote', 'accounts', 'total', 'total_tax', 'total_after_tax');

        return view('debit_notes.edit', $data);
    }

    public function update(CDNote $cdnote, Request $request)
    {
        $request->validate([
            'currency_id' => 'required|exists:currencies,id',
            'description' => 'required|string',
            'date' => 'required|date',
            'tax_id' => 'required',
        ]);

        $cdnote->update([
            'currency_id' => $request->currency_id,
            'description' => $request->description,
            'date' => $request->date,
            'tax_id' => $request->tax_id,
        ]);

        $total = 0;
        $total_tax = 0;

        $tax = $cdnote->tax;

        if ($request->input('account_id')[0] != null) {
            foreach ($request->input('account_id') as $key => $accountId) {
                $amount = $request->input('amount')[$key];
                $total += $amount;

                CDNoteItem::create([
                    'cdnote_id' => $cdnote->id,
                    'account_id' => $accountId,
                    'amount' => $amount,
                    'tax' => $amount * $tax->rate / 100,
                ]);

                $total_tax += $amount * $tax->rate / 100;

                // Account Credit transaction
                Transaction::create([
                    'user_id' => auth()->user()->id,
                    'account_id' => $accountId,
                    'currency_id' => $cdnote->currency_id,
                    'debit' => 0,
                    'credit' => $amount,
                    'balance' => 0 - $amount,
                ]);
            }
        }

        if ($total_tax != 0) {
            // Tax Credit transaction
            Transaction::create([
                'user_id' => auth()->user()->id,
                'account_id' => $tax->account_id,
                'currency_id' => $cdnote->currency_id,
                'debit' => 0,
                'credit' => $total_tax,
                'balance' => 0 - $total_tax,
            ]);
        }

        if ($total != 0) {
            // Supplier Debit transaction
            Transaction::create([
                'user_id' => auth()->user()->id,
                'account_id' => $cdnote->supplier->payable_account_id,
                'supplier_id' => $cdnote->supplier_id,
                'currency_id' => $cdnote->currency_id,
                'debit' => ($total + $total_tax),
                'credit' => 0,
                'balance' => ($total + $total_tax),
            ]);
        }

        $text = ucwords(auth()->user()->name) . ' updated Debit Note ' . $cdnote->cdnote_number . ", datetime :   " . now();
        Log::create(['text' => $text]);

        return redirect()->back()->with('warning', 'Debit Note updated successfully!');
    }

    public function show(CDNote $cdnote)
    {
        $total = 0;
        $total_tax = 0;
        $total_after_tax = 0;

        foreach ($cdnote->cdnote_items as $item) {
            $total += $item->amount;
            $total_tax += $item->tax;
        }
        $total_after_tax = $total + $total_tax;

        $data = compact('cdnote', 'total', 'total_tax', 'total_after_tax');
        return view('debit_notes.show', $data);
    }

    public function items(CDNote $cdnote)
    {
        $items = $cdnote->cdnote_items;

        $customizedItems = [];
        $index = 0;
        foreach ($items as $item) {
            $customizedItem = [
                'id' => $item->id,
                'name' => $item->account->account_number,
                'quantity' => $item->amount,
            ];
            $customizedItems[] = $customizedItem;
            $index++;
        }

        return response()->json($customizedItems);
    }

    public function destroy(CDNote $cdnote)
    {
        if ($cdnote->can_delete()) {
            $text = ucwords(auth()->user()->name) . " deleted Debit Note : " . $cdnote->cdnote_number . ", datetime :   " . now();

            Log::create(['text' => $text]);
            $cdnote->delete();

            return redirect()->back()->with('error', 'Debit Note deleted successfully!');
        } else {
            return redirect()->back()->with('error', 'Unable to delete...');
        }
    }
}
