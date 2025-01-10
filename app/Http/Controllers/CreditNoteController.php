<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\CDNote;
use App\Models\CDNoteItem;
use App\Models\Client;
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
        $cdnotes = CDNote::select('id', 'cdnote_number', 'client_id', 'type', 'date')->where('type', 'credit note')->filter()->orderBy('id', 'desc')->paginate(25);
        $clients = Client::select('id', 'name')->get();
        $data = compact('cdnotes', 'clients');

        return view('credit_notes.index', $data);
    }

    public function new()
    {
        $clients = Client::select('id', 'name', 'tax_id')->get();
        $accounts = Account::select('id', 'account_number', 'account_description')->get();

        $data = compact('accounts', 'clients');

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
            'account_id.*' => 'required|exists:accounts,id',
            'amount.*' => 'required|numeric',
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

            // Account Debit transaction
            Transaction::create([
                'user_id' => auth()->user()->id,
                'account_id' => $accountId,
                'currency_id' => $cdnote->currency_id,
                'debit' => $amount,
                'credit' => 0,
                'balance' => $amount,
            ]);
        }

        if ($total_tax != 0) {
            // Tax Debit transaction
            Transaction::create([
                'user_id' => auth()->user()->id,
                'account_id' => $tax->account_id,
                'currency_id' => $cdnote->currency_id,
                'debit' => $total_tax,
                'credit' => 0,
                'balance' => $total_tax,
            ]);
        }

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

        $total = 0;
        $total_tax = 0;
        $total_after_tax = 0;
        foreach ($cdnote->cdnote_items as $item) {
            $total += $item->amount;
            $total_tax += $item->tax;
            $total_after_tax += $item->tax;
        }

        $data = compact('cdnote', 'accounts', 'total', 'total_tax', 'total_after_tax');

        return view('credit_notes.edit', $data);
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

                // Account Debit transaction
                Transaction::create([
                    'user_id' => auth()->user()->id,
                    'account_id' => $accountId,
                    'currency_id' => $cdnote->currency_id,
                    'debit' => $amount,
                    'credit' => 0,
                    'balance' => $amount,
                ]);
            }
        }

        if ($total_tax != 0) {
            // Tax Debit transaction
            Transaction::create([
                'user_id' => auth()->user()->id,
                'account_id' => $tax->account_id,
                'currency_id' => $cdnote->currency_id,
                'debit' => $total_tax,
                'credit' => 0,
                'balance' => $total_tax,
            ]);
        }

        if ($total != 0) {
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
        }

        $text = ucwords(auth()->user()->name) . ' updated Credit Note ' . $cdnote->cdnote_number . ", datetime :   " . now();
        Log::create(['text' => $text]);

        return redirect()->back()->with('warning', 'Credit Note updated successfully!');
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
        return view('credit_notes.show', $data);
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
        $text = ucwords(auth()->user()->name) . " deleted Credit Note : " . $cdnote->cdnote_number . ", datetime :   " . now();

        Log::create(['text' => $text]);
        $cdnote->delete();

        return redirect()->back()->with('error', 'Credit Note deleted successfully!');
    }
}
