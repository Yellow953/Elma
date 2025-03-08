<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\CDNote;
use App\Models\Currency;
use App\Models\Supplier;
use App\Models\Log;
use App\Models\Tax;
use App\Models\Transaction;
use App\Models\Variable;
use Illuminate\Http\Request;

class DebitNoteController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:debit_notes.read')->only('index');
        $this->middleware('permission:debit_notes.create')->only(['new', 'create']);
        $this->middleware('permission:debit_notes.update')->only(['edit', 'update']);
        $this->middleware('permission:debit_notes.delete')->only('destroy');
    }

    public function index()
    {
        $cdnotes = CDNote::select('id', 'cdnote_number', 'supplier_id', 'type', 'date', 'amount', 'currency_id')->where('type', 'debit note')->filter()->orderBy('id', 'desc')->paginate(25);
        $suppliers = Supplier::select('id', 'name')->get();
        $currencies = Currency::select('id', 'code')->get();

        $data = compact('cdnotes', 'suppliers', 'currencies');
        return view('debit_notes.index', $data);
    }

    public function new()
    {
        $suppliers = Supplier::select('id', 'name', 'tax_id')->get();
        $currencies = Currency::select('id', 'code')->get();
        $taxes = Tax::select('id', 'name')->get();

        $data = compact('suppliers', 'taxes', 'currencies');
        return view('debit_notes.new', $data);
    }

    public function create(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'currency_id' => 'required|exists:currencies,id',
            'description' => 'required|string',
            'date' => 'required|date',
            'tax_id' => 'required|exists:taxes,id',
            'amount' => 'required|numeric',
        ]);

        $number = CDNote::generate_number('debit note');

        $tax = Tax::findOrFail($request->tax_id);
        $amount = $request->amount;
        $total_tax = $amount * ($tax->rate / 100);
        $total = $amount + $total_tax;
        $transactionsString = '';

        // Create Debit Note
        $cdnote = CDNote::create([
            'cdnote_number' => $number,
            'supplier_id' => $request->supplier_id,
            'currency_id' => $request->currency_id,
            'type' => 'debit note',
            'description' => $request->description,
            'date' => $request->date,
            'tax_id' => $request->tax_id,
            'amount' => $amount,
        ]);

        $supplier = Supplier::findOrFail($request->supplier_id);

        // Supplier Payable Account (Credit)
        $payable_account = Account::findOrFail(Variable::where('title', 'payable_account')->first()->value);
        $transaction = Transaction::create([
            'user_id' => auth()->user()->id,
            'account_id' => $payable_account->id,
            'supplier_id' => $supplier->id,
            'currency_id' => $cdnote->currency_id,
            'debit' => 0,
            'credit' => $total,
            'balance' => 0 - $total,
            'title' => 'Supplier Payable Adjustment',
            'description' => "Credit supplier payable for debit note #{$cdnote->cdnote_number}",
        ]);
        $transactionsString .= "{$transaction->id}|";

        // Expense Account (Debit)
        $expense_account = Account::findOrFail(Variable::where('title', 'expense_account')->first()->value);
        $transaction = Transaction::create([
            'user_id' => auth()->user()->id,
            'account_id' => $expense_account->id,
            'currency_id' => $cdnote->currency_id,
            'debit' => $amount,
            'credit' => 0,
            'balance' => $amount,
            'title' => 'Expense Adjustment',
            'description' => "Debit expense for debit note #{$cdnote->cdnote_number}",
        ]);
        $transactionsString .= "{$transaction->id}|";

        if ($total_tax != 0) {
            // Tax Account (Debit)
            $transaction = Transaction::create([
                'user_id' => auth()->user()->id,
                'account_id' => $tax->account_id,
                'currency_id' => $cdnote->currency_id,
                'debit' => $total_tax,
                'credit' => 0,
                'balance' => $total_tax,
                'title' => 'Tax Adjustment',
                'description' => "Debit tax for debit note #{$cdnote->cdnote_number}",
            ]);
            $transactionsString .= "{$transaction->id}|";
        }

        $cdnote->update([
            'transactions' => $transactionsString,
        ]);

        // Log the creation of the Debit Note
        $text = ucwords(auth()->user()->name) . " created new Debit Note: " . $cdnote->cdnote_number . ", datetime: " . now();
        Log::create(['text' => $text]);

        return redirect()->route('debit_notes')->with('success', 'Debit Note created successfully!');
    }


    public function edit(CDNote $cdnote)
    {
        return view('debit_notes.edit', compact('cdnote'));
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

            if ($cdnote->transactions) {
                foreach (explode('|', $cdnote->transactions) as $id) {
                    if ($id != '') {
                        Transaction::find($id)->delete();
                    }
                }
            }

            Log::create(['text' => $text]);
            $cdnote->delete();

            return redirect()->back()->with('error', 'Debit Note deleted successfully!');
        } else {
            return redirect()->back()->with('error', 'Unable to delete...');
        }
    }
}
