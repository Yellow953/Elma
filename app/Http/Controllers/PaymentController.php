<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Client;
use App\Models\Currency;
use App\Models\Log;
use App\Models\Payment;
use App\Models\Transaction;
use App\Models\Variable;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:payments.read')->only('index');
        $this->middleware('permission:payments.create')->only(['new', 'create']);
        $this->middleware('permission:payments.update')->only(['edit', 'update']);
        $this->middleware('permission:payments.delete')->only('destroy');
    }

    public function index()
    {
        $payments = Payment::select('id', 'payment_number', 'client_id', 'type', 'date', 'amount', 'currency_id')->where('type', 'LIKE', 'payment')->filter()->orderBy('id', 'desc')->paginate(25);
        $clients = Client::select('id', 'name')->get();
        $currencies = Currency::select('id', 'code')->get();

        $data = compact('payments', 'clients', 'currencies');
        return view('payments.index', $data);
    }

    public function new()
    {
        $clients = Client::select('id', 'name')->get();
        $currencies = Currency::select('id', 'code')->get();

        $data = compact('clients', 'currencies');
        return view('payments.new', $data);
    }

    public function create(Request $request)
    {
        $request->validate([
            'payment_number' => 'required|string|max:255|unique:payments',
            'client_id' => 'required|exists:clients,id',
            'currency_id' => 'required|exists:currencies,id',
            'description' => 'required|string',
            'date' => 'required|date',
            'amount' => 'required|numeric',
        ]);

        // $number = Payment::generate_number();
        $client = Client::find($request->client_id);

        $payment = Payment::create([
            'payment_number' => $request->payment_number,
            'client_id' => $request->client_id,
            'currency_id' => $request->currency_id,
            'type' => 'payment',
            'description' => $request->description,
            'date' => $request->date,
            'amount' => $request->amount,
        ]);

        $transactionsString = '';

        // Receivable Account Transaction
        $receivable_account = Account::findOrFail(Variable::where('title', 'receivable_account')->first()->value);
        $transaction = Transaction::create([
            'user_id' => auth()->id(),
            'account_id' => $receivable_account->id,
            'client_id' => $client->id,
            'currency_id' => $request->currency_id,
            'debit' => 0,
            'credit' => $request->amount,
            'balance' => -$request->amount,
            'title' => 'Client Receivable Payment',
            'description' => "Payment received from client {$client->name}, Payment No: {$payment->payment_number}",
        ]);
        $transactionsString .= "{$transaction->id}|";

        // Cash Account Transaction
        $cash_account = Account::findOrFail(Variable::where('title', 'cash_account')->first()->value);
        $transaction = Transaction::create([
            'user_id' => auth()->id(),
            'account_id' => $cash_account->id,
            'currency_id' => $request->currency_id,
            'debit' => $request->amount,
            'credit' => 0,
            'balance' => $request->amount,
            'title' => 'Cash Payment Received',
            'description' => "Payment of {$request->amount} received in cash for Payment No: {$payment->payment_number}",
        ]);
        $transactionsString .= "{$transaction->id}|";

        $payment->update([
            'transactions' => $transactionsString,
        ]);

        // Log the payment creation
        $text = ucwords(auth()->user()->name) . " created new Payment : " . $payment->payment_number . ", datetime : " . now();
        Log::create(['text' => $text]);

        return redirect()->route('payments')->with('success', 'Payment created successfully!');
    }


    public function edit(Payment $payment)
    {
        return view('payments.edit', compact('payment'));
    }

    public function update(Payment $payment, Request $request)
    {
        $request->validate([
            'payment_number' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date',
        ]);

        $payment->update([
            'payment_number' => $request->payment_number,
            'description' => $request->description,
            'date' => $request->date,
        ]);

        $text = ucwords(auth()->user()->name) . ' updated payment ' . $payment->payment_number . ", datetime :   " . now();
        Log::create(['text' => $text]);

        return redirect()->back()->with('warning', 'payment updated successfully!');
    }

    public function show(Payment $payment)
    {
        $data = compact('payment');
        return view('payments.show', $data);
    }

    public function destroy(Payment $payment)
    {
        if ($payment->can_delete()) {
            $text = ucwords(auth()->user()->name) . " deleted payment : " . $payment->payment_number . ", datetime :   " . now();

            if ($payment->transactions) {
                foreach (explode('|', $payment->transactions) as $id) {
                    if ($id != '') {
                        Transaction::find($id)->delete();
                    }
                }
            }

            Log::create(['text' => $text]);
            $payment->delete();

            return redirect()->back()->with('error', 'payment deleted successfully!');
        } else {
            return redirect()->back()->with('error', 'Unable to delete...');
        }
    }
}
