<?php

namespace App\Http\Controllers;

use App\Exports\TrialBalanceExport;
use App\Models\Account;
use App\Models\AccountType;
use App\Models\Currency;
use App\Models\Transaction;
use App\Models\Log;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class AccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:accounts.read')->only('index');
        $this->middleware('permission:accounts.create')->only(['new', 'create']);
        $this->middleware('permission:accounts.update')->only(['edit', 'update']);
        $this->middleware('permission:accounts.delete')->only('destroy');
        $this->middleware('permission:accounts.export')->only('export');
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
        $total_debit = 0;
        $total_credit = 0;
        $total_balance = 0;
        $total_foreign_debit = 0;
        $total_foreign_credit = 0;
        $total_foreign_balance = 0;

        foreach ($account->transactions as $transaction) {
            $total_debit += $transaction->debit;
            $total_credit += $transaction->credit;
            $total_balance += $transaction->balance;
            $total_foreign_debit += $transaction->foreign_debit;
            $total_foreign_credit += $transaction->foreign_credit;
            $total_foreign_balance += $transaction->foreign_balance;
        }

        $data = compact('account', 'total_debit', 'total_credit', 'total_balance', 'total_foreign_debit', 'total_foreign_credit', 'total_foreign_balance');

        return view('accounts.statement', $data);
    }

    public function get_statement_of_accounts()
    {
        return view('accounts.get_statement_of_accounts');
    }

    public function statement_of_accounts(Request $request)
    {
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $from_account = $request->from_account;
        $to_account = $request->to_account;
        $mvt = $request->has('mvt');
        $bbf = $request->has('bbf');

        $accountsQuery = Account::when($from_date && $to_date, function ($query) use ($from_date, $to_date) {
            $query->with(['transactions' => function ($query) use ($from_date, $to_date) {
                $query->whereBetween('created_at', [$from_date, $to_date]);
            }]);
        })
            ->when($from_account && $to_account, function ($query) use ($from_account, $to_account) {
                $query->whereBetween('account_number', [$from_account, $to_account]);
            })
            ->when($from_account && !$to_account, function ($query) use ($from_account) {
                $query->where('account_number', $from_account);
            });

        $accounts = $accountsQuery->get();

        $statements = [];

        foreach ($accounts as $account) {
            $total_debit = 0;
            $total_credit = 0;
            $total_balance = 0;
            $total_foreign_debit = 0;
            $total_foreign_credit = 0;
            $total_foreign_balance = 0;

            if ($bbf && $from_date) {
                $previousTransactions = $account->transactions()
                    ->where('created_at', '<', $from_date)
                    ->get();

                foreach ($previousTransactions as $prevTransaction) {
                    $total_debit += $prevTransaction->debit;
                    $total_credit += $prevTransaction->credit;
                    $total_balance += $prevTransaction->balance;
                    $total_foreign_debit += $prevTransaction->foreign_debit;
                    $total_foreign_credit += $prevTransaction->foreign_credit;
                    $total_foreign_balance += $prevTransaction->foreign_balance;
                }
            }

            if ($mvt) {
                foreach ($account->transactions as $transaction) {
                    $total_debit += $transaction->debit;
                    $total_credit += $transaction->credit;
                    $total_balance += $transaction->balance;
                    $total_foreign_debit += $transaction->foreign_debit;
                    $total_foreign_credit += $transaction->foreign_credit;
                    $total_foreign_balance += $transaction->foreign_balance;
                }
            } else {
                $total_debit += $account->transactions->sum('debit');
                $total_credit += $account->transactions->sum('credit');
                $total_balance += $account->transactions->sum('balance');
                $total_foreign_debit += $account->transactions->sum('foreign_debit');
                $total_foreign_credit += $account->transactions->sum('foreign_credit');
                $total_foreign_balance += $account->transactions->sum('foreign_balance');
            }

            $statements[] = (object)[
                'account' => $account,
                'total_debit' => $total_debit,
                'total_credit' => $total_credit,
                'total_balance' => $total_balance,
                'total_foreign_debit' => $total_foreign_debit,
                'total_foreign_credit' => $total_foreign_credit,
                'total_foreign_balance' => $total_foreign_balance,
            ];
        }

        return view('accounts.statement_of_accounts', compact('statements'));
    }

    public function get_trial_balance()
    {
        return view('accounts.get_trial_balance');
    }


    public function trial_balance(Request $request)
    {
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $from_account = $request->from_account;
        $to_account = $request->to_account;
        $mvt = $request->has('mvt');
        $bbf = $request->has('bbf');
        $skip_empty = $request->boolean('skip_empty');

        $accountsQuery = Account::when($from_date && $to_date, function ($query) use ($from_date, $to_date) {
            $query->with(['transactions' => function ($query) use ($from_date, $to_date) {
                $query->whereBetween('created_at', [$from_date, $to_date]);
            }]);
        })
            ->when($from_account && $to_account, function ($query) use ($from_account, $to_account) {
                $query->whereBetween('account_number', [$from_account, $to_account]);
            })
            ->when($from_account && !$to_account, function ($query) use ($from_account) {
                $query->where('account_number', $from_account);
            });

        $accounts = $accountsQuery->get();

        $trialBalance = [];
        $all_credit = 0;
        $all_debit = 0;
        $all_balance = 0;

        foreach ($accounts as $account) {
            $creditTotal = 0;
            $debitTotal = 0;
            $balance = 0;

            if ($bbf && $from_date) {
                $previousTransactions = $account->transactions()
                    ->where('created_at', '<', $from_date)
                    ->get();

                foreach ($previousTransactions as $prevTransaction) {
                    $debitTotal += $prevTransaction->debit;
                    $creditTotal += $prevTransaction->credit;
                }
            }

            if ($mvt) {
                foreach ($account->transactions as $transaction) {
                    $debitTotal += $transaction->debit;
                    $creditTotal += $transaction->credit;
                }
            } else {
                $debitTotal += $account->transactions->sum('debit');
                $creditTotal += $account->transactions->sum('credit');
            }

            $balance = $debitTotal - $creditTotal;

            $all_credit += $creditTotal;
            $all_debit += $debitTotal;
            $all_balance += $balance;

            if ($skip_empty && $balance == 0) {
                continue;
            }

            $trialBalance[] = [
                'account' => $account,
                'credit_total' => $creditTotal,
                'debit_total' => $debitTotal,
                'balance' => $balance,
            ];
        }

        $data = compact('trialBalance', 'from_date', 'to_date', 'from_account', 'to_account', 'all_credit', 'all_debit', 'all_balance', 'skip_empty');

        return view('accounts.trial_balance', $data);
    }

    public function export_trial_balance(Request $request)
    {
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $from_account = $request->from_account;
        $to_account = $request->to_account;
        $skip_empty = $request->boolean('skip_empty');

        $accounts = Account::when($from_date && $to_date, function ($query) use ($from_date, $to_date) {
            $query->with(['transactions' => function ($query) use ($from_date, $to_date) {
                $query->whereBetween('created_at', [$from_date, $to_date]);
            }]);
        })
            ->when($from_account && $to_account, function ($query) use ($from_account, $to_account) {
                $query->whereBetween('account_number', [$from_account, $to_account]);
            })
            ->get();

        $trialBalance = [];

        foreach ($accounts as $account) {
            $creditTotal = $account->transactions->sum('credit');
            $debitTotal = $account->transactions->sum('debit');
            $balance = $debitTotal - $creditTotal;

            if ($skip_empty && $balance == 0) {
                continue;
            }

            $trialBalance[] = [
                'account_number' => $account->account_number,
                'account_description' => $account->account_description,
                'credit_total' => $creditTotal,
                'debit_total' => $debitTotal,
                'balance' => $balance,
            ];
        }

        $data = collect($trialBalance);

        return Excel::download(new TrialBalanceExport($data), 'trial_balance.xlsx');
    }

    public function closing(Request $request)
    {
        $request->validate([
            'from_account' => 'required',
            'to_account' => 'required',
            'from_date' => 'required|date',
            'to_date' => 'required|date',
            'profit_account' => 'required',
            'loss_account' => 'required',
            'closing_datetime' => 'required',
        ]);

        $accounts = Account::whereBetween('account_number', [$request->from_account, $request->to_account])->whereBetween('created_at', [$request->from_date, $request->to_date])->where('type', 'P/L')->get();
        $profit_account = Account::find($request->profit_account);
        $loss_account = Account::find($request->loss_account);
        $usd = Currency::where('code', 'USD')->first();
        $lbp = Currency::where('code', 'LBP')->first();
        $total = 0;

        $datetime = Carbon::create(
            $request->closing_datetime
        )->format('Y-m-d H:i:s');

        // calculate amounts and reset accounts
        foreach ($accounts as $account) {
            foreach ($account->transactions as $transaction) {
                Transaction::create([
                    'user_id' => auth()->user()->id,
                    'account_id' => $account->id,
                    'currency_id' => $usd->id,
                    'foreign_currency_id' => $lbp->id,
                    'debit' => $transaction->credit,
                    'credit' => $transaction->debit,
                    'balance' => -$transaction->balance,
                    'foreign_debit' => $transaction->foreign_credit,
                    'foreign_credit' => $transaction->foreign_debit,
                    'foreign_balance' => -$transaction->foreign_balance,
                    'rate' => $lbp->rate,
                    'hidden' => true,
                    'created_at' => $datetime,
                    'updated_at' => $datetime,
                ]);
                $total += $transaction->balance;
            }
        }

        // update profit and loss account
        if ($total > 0) {
            Transaction::create([
                'user_id' => auth()->user()->id,
                'account_id' => $loss_account->id,
                'currency_id' => $usd->id,
                'foreign_currency_id' => $lbp->id,
                'debit' =>  abs($total),
                'credit' => 0,
                'balance' => $total,
                'foreign_debit' => abs($total * $lbp->rate),
                'foreign_credit' => 0,
                'foreign_balance' => $total * $lbp->rate,
                'rate' => $lbp->rate,
                'created_at' => $datetime,
                'updated_at' => $datetime,
            ]);
        } else if ($total < 0) {
            Transaction::create([
                'user_id' => auth()->user()->id,
                'account_id' => $profit_account->id,
                'currency_id' => $usd->id,
                'foreign_currency_id' => $lbp->id,
                'debit' => 0,
                'credit' => abs($total),
                'balance' => $total,
                'foreign_debit' => 0,
                'foreign_credit' => abs($total * $lbp->rate),
                'foreign_balance' => $total * $lbp->rate,
                'rate' => $lbp->rate,
                'created_at' => $datetime,
                'updated_at' => $datetime,
            ]);
        }

        $text = ucwords(auth()->user()->name) . " initiated closing for accounts: " . $request->from_account . " to " . $request->to_account . " from date: " . $request->from_date . " to " . $request->to_date . ", datetime :   " . now();
        Log::create(['text' => $text]);

        return redirect()->back()->with('success', 'Closing Succeeded...');
    }
}
