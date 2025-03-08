<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\CDNote;
use App\Models\Client;
use App\Models\Currency;
use App\Models\Log;
use App\Models\Tax;
use App\Models\Transaction;
use App\Models\Variable;
use Illuminate\Http\Request;

class CreditNoteController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:credit_notes.read')->only('index');
        $this->middleware('permission:credit_notes.create')->only(['new', 'create']);
        $this->middleware('permission:credit_notes.update')->only(['edit', 'update']);
        $this->middleware('permission:credit_notes.delete')->only('destroy');
    }

    public function index()
    {
        $cdnotes = CDNote::select('id', 'cdnote_number', 'client_id', 'type', 'date', 'amount', 'currency_id')->where('type', 'credit note')->filter()->orderBy('id', 'desc')->paginate(25);
        $clients = Client::select('id', 'name')->get();
        $currencies = Currency::select('id', 'code')->get();

        $data = compact('cdnotes', 'clients', 'currencies');
        return view('credit_notes.index', $data);
    }

    public function new()
    {
        $clients = Client::select('id', 'name', 'tax_id')->get();
        $currencies = Currency::select('id', 'code')->get();
        $taxes = Tax::select('id', 'name')->get();

        $data = compact('clients', 'currencies', 'taxes');
        return view('credit_notes.new', $data);
    }

    public function create(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'currency_id' => 'required|exists:currencies,id',
            'description' => 'required|string',
            'date' => 'required|date',
            'tax_id' => 'required|exists:taxes,id',
            'amount' => 'required|numeric|min:0',
        ]);

        $number = CDNote::generate_number('credit note');

        // Create the credit note
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

        // Calculate tax and total
        $tax = Tax::findOrFail($request->tax_id);
        $tax_rate = $tax->rate / 100;
        $amount = $request->amount;
        $total_tax = $amount * $tax_rate;
        $total = $amount;
        $transactionsString = '';

        // Revenue Debit Transaction
        $revenue_account = Account::findOrFail(Variable::where('title', 'revenue_account')->first()->value);
        $transaction = Transaction::create([
            'user_id' => auth()->user()->id,
            'account_id' => $revenue_account->id,
            'currency_id' => $cdnote->currency_id,
            'debit' => $amount,
            'credit' => 0,
            'balance' => $amount,
            'title' => 'Credit Note Revenue Adjustment',
            'description' => "Debit revenue for credit note #{$cdnote->cdnote_number}",
        ]);
        $transactionsString .= "{$transaction->id}|";

        if ($total_tax != 0) {
            // Tax Debit Transaction
            $transaction = Transaction::create([
                'user_id' => auth()->user()->id,
                'account_id' => $tax->account_id,
                'currency_id' => $cdnote->currency_id,
                'debit' => $total_tax,
                'credit' => 0,
                'balance' => $total_tax,
                'title' => 'Credit Note Tax Adjustment',
                'description' => "Debit tax for credit note #{$cdnote->cdnote_number}",
            ]);
            $transactionsString .= "{$transaction->id}|";
        }

        // Client Credit Transaction
        $client = Client::findOrFail($request->client_id);
        $receivable_account = Account::findOrFail(Variable::where('title', 'receivable_account')->first()->value);
        $transaction = Transaction::create([
            'user_id' => auth()->user()->id,
            'account_id' => $receivable_account->id,
            'client_id' => $client->id,
            'currency_id' => $cdnote->currency_id,
            'debit' => 0,
            'credit' => ($amount + $total_tax),
            'balance' => 0 - ($amount + $total_tax),
            'title' => 'Client Receivable Adjustment',
            'description' => "Credit client receivable for credit note #{$cdnote->cdnote_number}",
        ]);
        $transactionsString .= "{$transaction->id}|";

        $cdnote->update([
            'transactions' => $transactionsString,
        ]);

        // Log creation
        $text = ucwords(auth()->user()->name) . " created new Credit Note: " . $cdnote->cdnote_number . ", datetime: " . now();
        Log::create(['text' => $text]);

        return redirect()->route('credit_notes')->with('success', 'Credit Note created successfully!');
    }


    public function edit(CDNote $cdnote)
    {
        $data = compact('cdnote');
        return view('credit_notes.edit', $data);
    }

    public function update(CDNote $cdnote, Request $request)
    {
        $request->validate([
            'description' => 'required|string',
            'date' => 'required|date',
        ]);

        $cdnote->update([
            'description' => $request->description,
            'date' => $request->date,
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

            if ($cdnote->transactions) {
                foreach (explode('|', $cdnote->transactions) as $id) {
                    if ($id != '') {
                        Transaction::find($id)->delete();
                    }
                }
            }

            Log::create(['text' => $text]);
            $cdnote->delete();

            return redirect()->back()->with('error', 'Credit Note deleted successfully!');
        } else {
            return redirect()->back()->with('error', 'Unable to delete...');
        }
    }
}
