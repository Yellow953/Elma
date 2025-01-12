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
    
        DB::transaction(function () use ($request, $number) {
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
            $total = $amount; // Net amount before tax
    
            // Expense Debit Transaction
            $expense_account = Account::findOrFail(Variable::where('title', 'expense_account')->first()->value);
            Transaction::create([
                'user_id' => auth()->user()->id,
                'account_id' => $expense_account->id,
                'currency_id' => $cdnote->currency_id,
                'debit' => $amount,
                'credit' => 0,
                'balance' => $amount,
            ]);
    
            // Tax Debit Transaction
            Transaction::create([
                'user_id' => auth()->user()->id,
                'account_id' => $tax->account_id,
                'currency_id' => $cdnote->currency_id,
                'debit' => $total_tax,
                'credit' => 0,
                'balance' => $total_tax,
            ]);
    
            // Client Credit Transaction
            $client = Client::findOrFail($request->client_id);
            $receivable_account = Account::findOrFail(Variable::where('title','receivable_account')->first()->value);
            Transaction::create([
                'user_id' => auth()->user()->id,
                'account_id' => $receivable_account->id,
                'client_id' => $client->id,
                'currency_id' => $cdnote->currency_id,
                'debit' => 0,
                'credit' => ($amount + $total_tax),
                'balance' => 0 - ($amount + $total_tax),
            ]);
    
            // Log creation
            $text = ucwords(auth()->user()->name) . " created new Credit Note: " . $cdnote->cdnote_number . ", datetime: " . now();
            Log::create(['text' => $text]);
        });
    
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

            Log::create(['text' => $text]);
            $cdnote->delete();

            return redirect()->back()->with('error', 'Credit Note deleted successfully!');
        } else {
            return redirect()->back()->with('error', 'Unable to delete...');
        }
    }
}
