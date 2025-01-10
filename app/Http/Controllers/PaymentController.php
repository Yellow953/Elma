<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Log;
use App\Models\Payment;
use App\Models\PaymentItem;
use App\Models\Supplier;
use App\Models\Transaction;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:payments.read')->only('index');
        $this->middleware('permission:payments.create')->only(['new', 'create']);
        $this->middleware('permission:payments.update')->only(['edit', 'update']);
        $this->middleware('permission:payments.delete')->only('destroy');
        $this->middleware('permission:payments.export')->only('export');
    }

    public function index()
    {
        $payments = Payment::select('id', 'payment_number', 'supplier_id', 'type', 'date')->where('type', 'LIKE', 'payment')->filter()->orderBy('id', 'desc')->paginate(25);
        $suppliers = Supplier::select('id', 'name')->get();
        $data = compact('payments', 'suppliers');

        return view('payments.index', $data);
    }

    public function new()
    {
        $suppliers = Supplier::select('id', 'name')->get();
        $accounts = Account::select('id', 'account_number', 'account_description')->get();
        $data = compact('suppliers', 'accounts');

        return view('payments.new', $data);
    }

    public function create(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'currency_id' => 'required|exists:currencies,id',
            'description' => 'required|string',
            'date' => 'required|date',
            'account_id.*' => 'required|exists:accounts,id',
            'amount.*' => 'required|numeric',
        ]);

        $number = Payment::generate_number();

        $payment = Payment::create([
            'payment_number' => $number,
            'supplier_id' => $request->supplier_id,
            'currency_id' => $request->currency_id,
            'type' => 'payment',
            'description' => $request->description,
            'date' => $request->date,
        ]);

        $total = 0;

        foreach ($request->input('account_id') as $key => $accountId) {
            $amount = $request->input('amount')[$key];
            $total += $amount;

            PaymentItem::create([
                'payment_id' => $payment->id,
                'account_id' => $accountId,
                'amount' => $amount,
            ]);

            // Account Credit transaction
            Transaction::create([
                'user_id' => auth()->user()->id,
                'account_id' => $accountId,
                'currency_id' => $payment->currency_id,
                'debit' => 0,
                'credit' => $amount,
                'balance' => 0 - $amount,
            ]);
        }

        // Supplier Debit transaction
        $supplier = Supplier::find($request->supplier_id);
        Transaction::create([
            'user_id' => auth()->user()->id,
            'account_id' => $supplier->payable_account_id,
            'supplier_id' => $supplier->id,
            'currency_id' => $payment->currency_id,
            'debit' => $total,
            'credit' => 0,
            'balance' => $total,
        ]);

        $text = ucwords(auth()->user()->name) . " created new Payment : " . $payment->payment_number . ", datetime :   " . now();
        Log::create(['text' => $text]);

        return redirect()->route('payments')->with('success', 'Payment created successfully!');
    }

    public function edit(Payment $payment)
    {
        $accounts = Account::select('id', 'account_number', 'account_description')->get();

        $total = 0;
        foreach ($payment->payment_items as $item) {
            $total += $item->amount;
        }

        $data = compact('payment', 'accounts', 'total');
        return view('payments.edit', $data);
    }

    public function update(Payment $payment, Request $request)
    {
        $request->validate([
            'currency_id' => 'required|exists:currencies,id',
            'description' => 'required|string',
            'date' => 'required|date',
        ]);

        $payment->update([
            'currency_id' => $request->currency_id,
            'description' => $request->description,
            'date' => $request->date,
        ]);

        $total = 0;

        if ($request->input('account_id')[0] != null) {
            foreach ($request->input('account_id') as $key => $accountId) {
                $amount = $request->input('amount')[$key];
                $total += $amount;

                PaymentItem::create([
                    'payment_id' => $payment->id,
                    'account_id' => $accountId,
                    'amount' => $amount,
                ]);

                // Account Credit transaction
                Transaction::create([
                    'user_id' => auth()->user()->id,
                    'account_id' => $accountId,
                    'currency_id' => $payment->currency_id,
                    'debit' => 0,
                    'credit' => $amount,
                    'balance' => 0 - $amount,
                ]);
            }
        }

        if ($total != 0) {
            // Debit transaction
            Transaction::create([
                'user_id' => auth()->user()->id,
                'account_id' => $payment->supplier->payable_account_id,
                'supplier_id' => $payment->supplier_id,
                'currency_id' => $payment->currency_id,
                'debit' => $total,
                'credit' => 0,
                'balance' => $total,
            ]);
        }

        $text = ucwords(auth()->user()->name) . ' updated Payment ' . $payment->payment_number . ", datetime :   " . now();
        Log::create(['text' => $text]);

        return redirect()->back()->with('warning', 'Payment updated successfully!');
    }

    public function show(Payment $payment)
    {
        $total = 0;

        foreach ($payment->payment_items as $item) {
            $total += $item->amount;
        }

        $data = compact('payment', 'total');
        return view('payments.show', $data);
    }

    public function Return(Payment $payment)
    {
        $payments = Payment::select('id', 'payment_number')->where('type', 'payment')->get();
        return view('payments.return', compact('payment', 'payments'));
    }

    public function ReturnSave(Request $request)
    {
        $request->validate([
            'payment_id' => 'required',
            'items' => 'required|array',
        ]);

        $old_payment = Payment::find($request->input('payment_id'));
        $return_number = Payment::generate_return_number();

        $payment = Payment::create([
            'payment_number' => $return_number,
            'supplier_id' => $old_payment->supplier_id,
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
                    'debit' => 0,
                    'credit' => $amount,
                    'balance' => 0 - $amount,
                ]);

                $total += $amount;
            }
        }

        // Debit transaction
        Transaction::create([
            'user_id' => auth()->user()->id,
            'account_id' => $old_payment->supplier->payable_account_id,
            'supplier_id' => $old_payment->supplier_id,
            'currency_id' => $payment->currency_id,
            'debit' => $total,
            'credit' => 0,
            'balance' => $total,
        ]);

        Log::create([
            'text' => ucwords(auth()->user()->name) . ' Returned Payment ' . $payment->payment_number . ", datetime :   " . now(),
        ]);

        return redirect()->route('payments')->with('success', 'Payment Returned successfully!');
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
            $text = ucwords(auth()->user()->name) . " deleted Payment : " . $payment->payment_number . ", datetime :   " . now();

            Log::create(['text' => $text]);
            $payment->delete();

            return redirect()->back()->with('error', 'Payment deleted successfully!');
        } else {
            return redirect()->back()->with('error', 'Unable to delete...');
        }
    }
}
