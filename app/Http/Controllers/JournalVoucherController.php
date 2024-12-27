<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\JournalVoucher;
use App\Models\Log;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class JournalVoucherController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('setup');
        $this->middleware('agreed');
        $this->middleware('accountant');
    }

    public function index()
    {
        $journal_vouchers = JournalVoucher::select('id', 'date', 'currency_id', 'foreign_currency_id', 'user_id', 'description', 'status')->filter()->orderBy('id', 'desc')->paginate(25);
        $users = User::select('id', 'name')->get();
        $data = compact('journal_vouchers', 'users');

        return view('journal_vouchers.index', $data);
    }


    public function new()
    {
        $accounts = Account::select('id', 'account_number', 'account_description')->get();
        return view('journal_vouchers.new', compact('accounts'));
    }

    public function create(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'currency_id' => 'required|numeric',
            'foreign_currency_id' => 'required|numeric',
        ]);

        $journal_voucher = JournalVoucher::create([
            'user_id' => auth()->user()->id,
            'date' => $request->date,
            'currency_id' => $request->currency_id,
            'foreign_currency_id' => $request->foreign_currency_id,
            'rate' => $request->rate,
            'description' => $request->description,
            'batch' => $request->batch ?? 'A',
            'status' => 'unposted',
            'source' => 'user',
        ]);

        $this->attach_transactions($journal_voucher, $request);

        $text = ucwords(auth()->user()->name) . " created new Journal Voucher : " . $journal_voucher->id . ", datetime :   " . now();
        Log::create(['text' => $text]);

        return redirect()->route('journal_vouchers')->with('success', 'Journal Voucher created successfully!');
    }

    public function show(JournalVoucher $journal_voucher)
    {
        $total_debit = 0;
        $total_credit = 0;
        $total_balance = 0;
        $total_foreign_debit = 0;
        $total_foreign_credit = 0;
        $total_foreign_balance = 0;

        foreach ($journal_voucher->transactions as $transaction) {
            $total_debit += $transaction->debit;
            $total_credit += $transaction->credit;
            $total_balance += $transaction->balance;
            $total_foreign_debit += $transaction->foreign_debit;
            $total_foreign_credit += $transaction->foreign_credit;
            $total_foreign_balance += $transaction->foreign_balance;
        }

        $data = compact('journal_voucher', 'total_debit', 'total_credit', 'total_balance', 'total_foreign_debit', 'total_foreign_credit', 'total_foreign_balance');

        return view('journal_vouchers.show', $data);
    }

    public function edit(JournalVoucher $journal_voucher)
    {
        if ($journal_voucher->status == 'posted') {
            return redirect()->back()->with('error', "Journal Voucher posted, can't edit...");
        }

        $accounts = Account::select('id', 'account_number', 'account_description')->get();

        $total_debit = 0;
        $total_credit = 0;
        $total_balance = 0;
        $total_foreign = 0;

        foreach ($journal_voucher->transactions as $transaction) {
            $total_debit += $transaction->debit;
            $total_credit += $transaction->credit;
            $total_balance += $transaction->balance;
            $total_foreign += $transaction->foreign_balance;
        }

        $data = compact('journal_voucher', 'accounts', 'total_debit', 'total_credit', 'total_balance', 'total_foreign');

        return view('journal_vouchers.edit', $data);
    }

    public function update(JournalVoucher $journal_voucher, Request $request)
    {
        if ($journal_voucher->status == 'posted') {
            return redirect()->back()->with('error', "Journal Voucher posted, can't update...");
        }

        $request->validate([
            'date' => 'required|date',
            'currency_id' => 'required|numeric',
            'foreign_currency_id' => 'required|numeric',
        ]);

        $journal_voucher->update([
            'date' => $request->date,
            'currency_id' => $request->currency_id,
            'foreign_currency_id' => $request->foreign_currency_id,
            'description' => $request->description,
            'batch' => $request->batch ?? 'A',
            'status' => 'unposted',
            'source' => 'user',
        ]);

        $this->attach_transactions($journal_voucher, $request);

        $text = ucwords(auth()->user()->name) . ' updated Journal Voucher ' . $journal_voucher->id . ", datetime :   " . now();
        Log::create(['text' => $text]);

        return redirect()->back()->with('warning', 'Journal Voucher updated successfully!');
    }

    public function destroy(JournalVoucher $journal_voucher)
    {
        if ($journal_voucher->can_delete()) {
            foreach ($journal_voucher->transactions as $transaction) {
                $transaction->delete();
            }

            $text = ucwords(auth()->user()->name) . ' voided Journal Voucher ' . $journal_voucher->id . ", datetime :   " . now();
            Log::create(['text' => $text]);

            $journal_voucher->delete();

            return redirect()->back()->with('error', 'Journal Voucher deleted successfully!');
        } else {
            return redirect()->back()->with('error', 'Unothorized Access...');
        }
    }

    public function post(JournalVoucher $journal_voucher)
    {
        if ($journal_voucher->status == 'posted') {
            return redirect()->back()->with('error', "Journal Voucher already posted...");
        }

        $total = 0;
        foreach ($journal_voucher->transactions as $transaction) {
            $total += $transaction->debit - $transaction->credit;
        }

        if ($total == 0) {
            $journal_voucher->update([
                'status' => 'posted',
            ]);

            $text = ucwords(auth()->user()->name) . ' posted Journal Voucher ' . $journal_voucher->id . ", datetime :   " . now();
            Log::create(['text' => $text]);

            return redirect()->back()->with('success', 'Journal Voucher posted successfully!');
        } else {
            return redirect()->back()->with('danger', 'Cannot Post! Transacrions Sum not 0...');
        }
    }

    public function batch_post(Request $request)
    {
        $batch = $request->batch;
        $jvs = JournalVoucher::where('status', 'unposted')->where('batch', 'LIKE',  "%{$batch}%")->get();

        if ($jvs->count() == 0) {
            return redirect()->back()->with('All Journal Vouchers are Posted Or Not Found...');
        }

        foreach ($jvs as $jv) {
            $total = 0;
            foreach ($jv->transactions as $transaction) {
                $total += $transaction->debit - $transaction->credit;
            }

            if ($total == 0) {
                $jv->update(['status' => 'posted']);
            }
        }

        $text = ucwords(auth()->user()->name) . ' posted all Journal Vouchers with batch: ' . $request->batch . ", datetime :   " . now();
        Log::create(['text' => $text]);

        return redirect()->back()->with('success', 'Batch posted successfully!');
    }

    public function void(JournalVoucher $journal_voucher)
    {
        if ($journal_voucher->status == 'unposted') {
            return redirect()->back()->with('error', "Journal Voucher unposted...");
        }

        if ($journal_voucher->can_delete()) {
            foreach ($journal_voucher->transactions as $transaction) {
                $transaction->delete();
            }

            $text = ucwords(auth()->user()->name) . ' voided Journal Voucher ' . $journal_voucher->id . ", datetime :   " . now();
            Log::create(['text' => $text]);

            $journal_voucher->delete();

            return redirect()->back()->with('error', 'Journal Voucher voided successfully!');
        } else {
            return redirect()->back()->with('error', 'Journal Voucher cannot be voided!');
        }
    }

    public function backout(JournalVoucher $journal_voucher)
    {
        if ($journal_voucher->status == 'unposted') {
            return redirect()->back()->with('error', "Journal Voucher unposted...");
        }

        $new_jv = $journal_voucher->replicate();
        $new_jv->push();
        $new_jv->update(['status' => 'unposted']);

        foreach ($journal_voucher->transactions as $transaction) {
            $new_transaction = $transaction->replicate();
            $new_transaction->push();
            $new_transaction->update([
                'journal_voucher_id' => $new_jv->id,
                'credit' => $transaction->debit,
                'debit' => $transaction->credit,
                'balance' => $transaction->credit - $transaction->debit,
                'foreign_credit' => $transaction->foreign_debit,
                'foreign_debit' => $transaction->foreign_credit,
                'foreign_balance' => $transaction->foreign_credit - $transaction->foreign_debit,
                'user_id' => auth()->user()->id
            ]);
        }

        $text = ucwords(auth()->user()->name) . ' backout Journal Voucher: ' . $journal_voucher->id . " to new Journal Voucher: " . $new_jv->id . ", datetime :   " . now();
        Log::create(['text' => $text]);

        return redirect()->route('journal_vouchers.edit', $new_jv->id)->with('warning', 'Journal Voucher backout successfully!');
    }

    public function copy(JournalVoucher $journal_voucher)
    {
        if ($journal_voucher->status == 'unposted') {
            return redirect()->back()->with('error', "Journal Voucher unposted...");
        }

        $new_jv = $journal_voucher->replicate();
        $new_jv->push();
        $new_jv->update(['status' => 'unposted']);

        foreach ($journal_voucher->transactions as $transaction) {
            $new_transaction = $transaction->replicate();
            $new_transaction->push();
            $new_transaction->update([
                'journal_voucher_id' => $new_jv->id,
                'user_id' => auth()->user()->id
            ]);
        }

        $text = ucwords(auth()->user()->name) . ' copied Journal Voucher: ' . $journal_voucher->id . " to new Journal Voucher: " . $new_jv->id . ", datetime :   " . now();
        Log::create(['text' => $text]);

        return redirect()->route('journal_vouchers.edit', $new_jv->id)->with('warning', 'Journal Voucher copied successfully!');
    }

    private function attach_transactions($journal_voucher, $request)
    {
        foreach ($request->transactions['account_id'] as $index => $accountId) {
            if ($request->transactions['account_id'][0]) {
                $rate = $request->rate ?? $journal_voucher->foreign_currency->rate;
                $credit = $request->transactions['credit'][$index] ?? 0;
                $debit = $request->transactions['debit'][$index] ?? 0;

                Transaction::create([
                    'journal_voucher_id' => $journal_voucher->id,
                    'user_id' => auth()->user()->id,
                    'currency_id' => $journal_voucher->currency_id,
                    'foreign_currency_id' => $journal_voucher->foreign_currency_id,
                    'account_id' => $accountId,
                    'credit' => $credit,
                    'debit' => $debit,
                    'balance' => $debit - $credit,
                    'foreign_credit' => $credit * $rate,
                    'foreign_debit' => $debit * $rate,
                    'foreign_balance' => ($debit - $credit) * $rate,
                    'rate' => $rate,
                ]);
            }
        }

        return;
    }
}
