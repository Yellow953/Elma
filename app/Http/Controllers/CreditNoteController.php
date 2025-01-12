<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\CDNote;
use App\Models\CDNoteItem;
use App\Models\Client;
use App\Models\Currency;
use App\Models\Log;
use App\Models\Tax;
use App\Models\Transaction;
use Illuminate\Http\Request;

class CreditNoteController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:credit_notes.read')->only('index');
        $this->middleware('permission:credit_notes.create')->only(['new', 'create']);
        $this->middleware('permission:credit_notes.update')->only(['edit', 'update']);
        $this->middleware('permission:credit_notes.delete')->only('destroy');
        $this->middleware('permission:credit_notes.export')->only('export');
    }

    public function index()
    {
        $cdnotes = CDNote::select('id', 'cdnote_number', 'client_id', 'type', 'date', 'amount')->where('type', 'credit note')->filter()->orderBy('id', 'desc')->paginate(25);
        $clients = Client::select('id', 'name')->get();
        $currencies = Currency::select('id', 'name')->get();

        $data = compact('cdnotes', 'clients', 'currencies');
        return view('credit_notes.index', $data);
    }

    public function new()
    {
        $clients = Client::select('id', 'name', 'tax_id')->get();
        $currencies = Currency::select('id', 'name')->get();

        $data = compact('accounts', 'clients', 'currencies');
        return view('credit_notes.new', $data);
    }

    public function create(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'currency_id' => 'required|exists:currencies,id',
            'description' => 'required|string',
            'date' => 'required|date',
            'tax_id' => 'required',
            'amount' => 'required|numeric',
        ]);

        $number = CDNote::generate_number('credit note');

        $cdnote = CDNote::create([
            'cdnote_number' => $number,
            'client_id' => $request->client_id,
            'currency_id' => $request->currency_id,
            'type' => 'credit note',
            'description' => $request->description,
            'date' => $request->date,
            'tax_id' => $request->tax_id,
            'amount' => $request->amount,
        ]);

        // Account Debit transaction
        Transaction::create([
            'user_id' => auth()->user()->id,
            'account_id' => $accountId,
            'currency_id' => $cdnote->currency_id,
            'debit' => $amount,
            'credit' => 0,
            'balance' => $amount,
        ]);
        // Tax Debit transaction
        Transaction::create([
            'user_id' => auth()->user()->id,
            'account_id' => $tax->account_id,
            'currency_id' => $cdnote->currency_id,
            'debit' => $total_tax,
            'credit' => 0,
            'balance' => $total_tax,
        ]);
        // Client Credit transaction
        $client = Client::find($request->client_id);
        Transaction::create([
            'user_id' => auth()->user()->id,
            'account_id' => $client->receivable_account_id,
            'client_id' => $client->id,
            'currency_id' => $cdnote->currency_id,
            'debit' => 0,
            'credit' => ($total + $total_tax),
            'balance' => 0 - ($total + $total_tax),
        ]);

        $text = ucwords(auth()->user()->name) . " created new Credit Note : " . $cdnote->cdnote_number . ", datetime :   " . now();
        Log::create(['text' => $text]);

        return redirect()->route('credit_notes')->with('success', 'Credit Note created successfully!');
    }

    public function edit(CDNote $cdnote)
    {
        $accounts = Account::select('id', 'account_number', 'account_description')->get();
        $currencies = Currency::select('id', 'name')->get();

        $data = compact('cdnote', 'accounts', 'currencies');
        return view('credit_notes.edit', $data);
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

        // Account Debit transaction
        Transaction::create([
            'user_id' => auth()->user()->id,
            'account_id' => $accountId,
            'currency_id' => $cdnote->currency_id,
            'debit' => $amount,
            'credit' => 0,
            'balance' => $amount,
        ]);
        // Tax Debit transaction
        Transaction::create([
            'user_id' => auth()->user()->id,
            'account_id' => $tax->account_id,
            'currency_id' => $cdnote->currency_id,
            'debit' => $total_tax,
            'credit' => 0,
            'balance' => $total_tax,
        ]);
        // Client Credit transaction
        Transaction::create([
            'user_id' => auth()->user()->id,
            'account_id' => $cdnote->client->receivable_account_id,
            'client_id' => $cdnote->client_id,
            'currency_id' => $cdnote->currency_id,
            'debit' => 0,
            'credit' => ($total + $total_tax),
            'balance' => 0 - ($total + $total_tax),
        ]);

        $text = ucwords(auth()->user()->name) . ' updated Credit Note ' . $cdnote->cdnote_number . ", datetime :   " . now();
        Log::create(['text' => $text]);

        return redirect()->back()->with('warning', 'Credit Note updated successfully!');
    }

    public function show(CDNote $cdnote)
    {
        $data = compact('cdnote');
        return view('credit_notes.show', $data);
    }

    public function destroy(CDNote $cdnote)
    {
        if ($cdnote->can_delete()) {
            $text = ucwords(auth()->user()->name) . " deleted Credit Note : " . $cdnote->cdnote_number . ", datetime :   " . now();

            Log::create(['text' => $text]);
            $cdnote->delete();

            return redirect()->back()->with('error', 'Credit Note deleted successfully!');
        } else {
            return redirect()->back()->with('error', 'Unable to delete...');
        }
    }
}
