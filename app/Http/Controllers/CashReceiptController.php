<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Client;
use App\Models\Currency;
use App\Models\Log;
use App\Models\Payment;
use App\Models\Transaction;
use Illuminate\Http\Request;

class CashReceiptController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:cash_receipts.read')->only('index');
        $this->middleware('permission:cash_receipts.create')->only(['new', 'create']);
        $this->middleware('permission:cash_receipts.update')->only(['edit', 'update']);
        $this->middleware('permission:cash_receipts.delete')->only('destroy');
        $this->middleware('permission:cash_receipts.export')->only('export');
    }

    public function index()
    {
        $payments = Payment::select('id', 'payment_number', 'client_id', 'type', 'date', 'amount')->where('type', 'LIKE', 'cash receipt')->filter()->orderBy('id', 'desc')->paginate(25);
        $clients = Client::select('id', 'name')->get();
        $currencies = Currency::select('id', 'name')->get();

        $data = compact('payments', 'clients', 'currencies');
        return view('cash_receipts.index', $data);
    }

    public function new()
    {
        $clients = Client::select('id', 'name')->get();
        $currencies = Currency::select('id', 'name')->get();

        $data = compact('clients', 'currencies');
        return view('cash_receipts.new', $data);
    }

    public function create(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'currency_id' => 'required|exists:currencies,id',
            'description' => 'required|string',
            'date' => 'required|date',
            'amount' => 'required|numeric',
        ]);

        $number = Payment::generate_number();

        $payment = Payment::create([
            'payment_number' => $number,
            'client_id' => $request->client_id,
            'currency_id' => $request->currency_id,
            'type' => 'cash receipt',
            'description' => $request->description,
            'date' => $request->date,
            'amount' => $request->amount,
        ]);

        // Account Debit transaction
        Transaction::create([
            'user_id' => auth()->user()->id,
            'account_id' => $accountId,
            'currency_id' => $payment->currency_id,
            'debit' => $request->amount,
            'credit' => 0,
            'balance' => $request->amount,
        ]);

        // Client Credit transaction
        $client = Client::find($request->client_id);
        Transaction::create([
            'user_id' => auth()->user()->id,
            'account_id' => $client->receivable_account_id,
            'client_id' => $client->id,
            'currency_id' => $payment->currency_id,
            'debit' => 0,
            'credit' => $request->amount,
            'balance' => (0 - $request->amount),
        ]);

        $text = ucwords(auth()->user()->name) . " created new Cash Receipt : " . $payment->payment_number . ", datetime :   " . now();
        Log::create(['text' => $text]);

        return redirect()->route('cash_receipts')->with('success', 'Cash Receipt created successfully!');
    }

    public function edit(Payment $payment)
    {
        $currencies = Currency::select('id', 'name')->get();

        $data = compact('payment', 'currencies');
        return view('cash_receipts.edit', $data);
    }

    public function update(Payment $payment, Request $request)
    {
        $request->validate([
            'currency_id' => 'required|exists:currencies,id',
            'description' => 'required|string',
            'date' => 'required|date',
            'amount' => 'required',
        ]);

        $payment->update([
            'currency_id' => $request->currency_id,
            'description' => $request->description,
            'date' => $request->date,
            'amount' => $request->amount,
        ]);

        // Account Debit transaction
        Transaction::create([
            'user_id' => auth()->user()->id,
            'account_id' => $accountId,
            'currency_id' => $payment->currency_id,
            'debit' => $request->amount,
            'credit' => 0,
            'balance' => $request->amount,
        ]);

        // Credit transaction
        Transaction::create([
            'user_id' => auth()->user()->id,
            'account_id' => $payment->client->receivable_account_id,
            'client_id' => $payment->client_id,
            'currency_id' => $payment->currency_id,
            'debit' => 0,
            'credit' => $request->amount,
            'balance' => 0 - $request->amount,
        ]);

        $text = ucwords(auth()->user()->name) . ' updated Cash Receipt ' . $payment->payment_number . ", datetime :   " . now();
        Log::create(['text' => $text]);

        return redirect()->back()->with('warning', 'Cash Receipt updated successfully!');
    }

    public function show(Payment $payment)
    {
        $data = compact('payment');
        return view('cash_receipts.show', $data);
    }

    public function Return(Payment $payment)
    {
        $payments = Payment::select('id', 'payment_number')->where('type', 'cash receipt')->get();
        return view('cash_receipts.return', compact('payment', 'payments'));
    }

    public function ReturnSave(Request $request)
    {
        $request->validate([
            'payment_id' => 'required',
            'items' => 'required|array',
        ]);

        $old_payment = Payment::find($request->input('payment_id'));

        $payment = Payment::create([
            'payment_number' => Payment::generate_return_number(),
            'client_id' => $old_payment->client_id,
            'currency_id' => $old_payment->currency_id,
            'type' => 'return ' . $old_payment->type,
            'description' => $old_payment->description,
            'date' => date('Y-m-d'),
        ]);

        $total = 0;

        foreach ($request->items as $index => $item) {
            if (isset($item['id'])) {
                $old_account = PaymentItem::find($item['id'])->account;
                $amount = $item['quantity'];

                PaymentItem::create([
                    'payment_id' => $payment->id,
                    'account_id' => $old_account->id,
                    'amount' => $amount,
                ]);

                // Account Credit transaction
                Transaction::create([
                    'user_id' => auth()->user()->id,
                    'account_id' => $old_account->id,
                    'currency_id' => $payment->currency_id,
                    'debit' => $amount,
                    'credit' => 0,
                    'balance' => $amount,
                ]);
                $total += $amount;
            }
        }

        // Credit transaction
        Transaction::create([
            'user_id' => auth()->user()->id,
            'account_id' => $old_payment->client->receivable_account_id,
            'client_id' => $old_payment->client_id,
            'currency_id' => $payment->currency_id,
            'debit' => 0,
            'credit' => $total,
            'balance' => 0 - $total,
        ]);

        Log::create([
            'text' => ucwords(auth()->user()->name) . ' Returned Cash Receipt ' . $payment->payment_number . ", datetime :   " . now(),
        ]);

        return redirect()->route('cash_receipts')->with('success', 'Cash Receipt Returned successfully!');
    }

    public function items(Payment $payment)
    {
        $items = $payment->payment_items;

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

    public function destroy(Payment $payment)
    {
        if ($payment->can_delete()) {
            $text = ucwords(auth()->user()->name) . " deleted Cash Receipt : " . $payment->payment_number . ", datetime :   " . now();

            Log::create(['text' => $text]);
            $payment->delete();

            return redirect()->back()->with('error', 'Cash Receipt deleted successfully!');
        } else {
            return redirect()->back()->with('error', 'Unable to delete...');
        }
    }
}
