<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\CDNote;
use App\Models\CDNoteItem;
use App\Models\Currency;
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
        $cdnotes = CDNote::select('id', 'cdnote_number', 'supplier_id', 'type', 'date', 'amount')->where('type', 'debit note')->filter()->orderBy('id', 'desc')->paginate(25);
        $suppliers = Supplier::select('id', 'name')->get();
        $currencies = Currency::select('id', 'name')->get();

        $data = compact('cdnotes', 'suppliers', 'currencies');
        return view('debit_notes.index', $data);
    }

    public function new()
    {
        $suppliers = Supplier::select('id', 'name', 'tax_id')->get();
        $currencies = Currency::select('id', 'name')->get();

        $data = compact('suppliers', 'accounts', 'currencies');
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
            'amount' => 'required|numeric',
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
            'amount' => $request->amount,
        ]);

        // Account Credit transaction
        Transaction::create([
            'user_id' => auth()->user()->id,
            'account_id' => $accountId,
            'currency_id' => $cdnote->currency_id,
            'debit' => 0,
            'credit' => $amount,
            'balance' => 0 - $amount,
        ]);
        // Tax Credit transaction
        Transaction::create([
            'user_id' => auth()->user()->id,
            'account_id' => $tax->account_id,
            'currency_id' => $cdnote->currency_id,
            'debit' => 0,
            'credit' => $total_tax,
            'balance' => 0 - $total_tax,
        ]);

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
        $data = compact('cdnote');
        return view('debit_notes.edit', $data);
    }

    public function update(CDNote $cdnote, Request $request)
    {
        $request->validate([
            'currency_id' => 'required|exists:currencies,id',
            'description' => 'required|string',
            'date' => 'required|date',
            'tax_id' => 'required',
            'amount' => 'required|numeric',
        ]);

        $cdnote->update([
            'currency_id' => $request->currency_id,
            'description' => $request->description,
            'date' => $request->date,
            'tax_id' => $request->tax_id,
            'amount' => $request->amount,
        ]);

        $total = 0;
        $total_tax = 0;

        // Account Credit transaction
        Transaction::create([
            'user_id' => auth()->user()->id,
            'account_id' => $accountId,
            'currency_id' => $cdnote->currency_id,
            'debit' => 0,
            'credit' => $amount,
            'balance' => 0 - $amount,
        ]);
        // Tax Credit transaction
        Transaction::create([
            'user_id' => auth()->user()->id,
            'account_id' => $tax->account_id,
            'currency_id' => $cdnote->currency_id,
            'debit' => 0,
            'credit' => $total_tax,
            'balance' => 0 - $total_tax,
        ]);
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

        $text = ucwords(auth()->user()->name) . ' updated Debit Note ' . $cdnote->cdnote_number . ", datetime :   " . now();
        Log::create(['text' => $text]);

        return redirect()->back()->with('warning', 'Debit Note updated successfully!');
    }

    public function show(CDNote $cdnote)
    {
        $data = compact('cdnote');
        return view('debit_notes.show', $data);
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
