<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\AccountType;
use App\Models\Transaction;
use App\Models\Log;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:accounts.read')->only('index');
        $this->middleware('permission:accounts.create')->only(['new', 'create']);
        $this->middleware('permission:accounts.update')->only(['edit', 'update']);
        $this->middleware('permission:accounts.delete')->only('destroy');
    }

    public function index()
    {
        $accounts = Account::select('id', 'account_number', 'account_description', 'type', 'currency_id')->filter()->orderBy('id', 'desc')->paginate(25);

        return view('accounts.index', compact('accounts'));
    }

    public function new()
    {
        $account_types = AccountType::select('id', 'name', 'parent_id', 'level')->get();
        return view('accounts.new', compact('account_types'));
    }

    public function create(Request $request)
    {
        $request->validate([
            'account_number' => ['required', 'string', 'max:16', 'min:14', 'unique:accounts'],
            'account_description' => 'string|required',
            'type' => 'required',
            'currency_id' => 'required',
        ]);

        $account = Account::create([
            'account_number' => $request->account_number,
            'account_description' => $request->account_description,
            'currency_id' => $request->currency_id,
            'type' => AccountType::find($request->type)->name,
            'sub1' => $request->sub1 ? AccountType::find($request->sub1)->name : null,
            'sub2' => $request->sub2 ? AccountType::find($request->sub2)->name : null,
        ]);

        $text = ucwords(auth()->user()->name) . " created new Account : " . $account->account_number . ", datetime :   " . now();
        Log::create(['text' => $text]);

        return redirect()->route('accounts')->with('success', 'Account created successfully!');
    }

    public function edit(Account $account)
    {
        $data = compact('account');
        return view('accounts.edit', $data);
    }

    public function update(Account $account, Request $request)
    {
        $request->validate([
            'account_description' => 'string|required',
            'currency_id' => 'required',
        ]);

        $account->update([
            'account_description' => $request->account_description,
            'currency_id' => $request->currency_id,
        ]);

        $text = ucwords(auth()->user()->name) . ' updated account ' . $account->account_number . ", datetime :   " . now();
        Log::create(['text' => $text]);

        return redirect()->route('accounts')->with('warning', 'Account updated successfully!');
    }

    public function destroy(Account $account)
    {
        if ($account->can_delete()) {
            $text = ucwords(auth()->user()->name) . " deleted Account : " . $account->account_number . ", datetime :   " . now();

            Log::create(['text' => $text]);
            $account->delete();

            return redirect()->back()->with('error', 'Account deleted successfully!');
        } else {
            return redirect()->back()->with('error', 'Unothorized Access...');
        }
    }

    public function statement(Account $account)
    {
        if ($account->client) {
            $transactions = $account->client->transactions()->orderBy('created_at', 'ASC')->get();
        } else if ($account->supplier) {
            $transactions = $account->supplier->transactions()->orderBy('created_at', 'ASC')->get();
        } else {
            $transactions = $account->transactions()->orderBy('created_at', 'ASC')->get();
        }

        $data = compact('account', 'transactions');
        return view('accounts.statement', $data);
    }

    public function get_trial_balance()
    {
        return view('accounts.get_trial_balance');
    }

    public function trial_balance(Request $request)
    {
        $request->validate([
            'from_date' => 'nullable|date',
            'to_date' => 'nullable|date|after_or_equal:from_date',
        ]);

        if ($request->from_date || $request->to_date) {
            $from_date = $request->from_date ?? '1900-01-01';
            $to_date = $request->to_date ?? now();

            $transactions = Transaction::whereNotNull('client_id')
                ->whereBetween('created_at', [$from_date, $to_date])
                ->get();
        } else {
            $transactions = Transaction::whereNotNull('client_id')->get();
        }

        $trialBalance = $transactions->groupBy('client_id')->map(function ($clientTransactions) {
            return [
                'client' => $clientTransactions->first()->client->name,
                'total_debit' => $clientTransactions->sum('debit'),
                'total_credit' => $clientTransactions->sum('credit'),
                'balance' => $clientTransactions->sum('debit') - $clientTransactions->sum('credit'),
            ];
        });

        return view('accounts.trial_balance', compact('trialBalance'));
    }
}
