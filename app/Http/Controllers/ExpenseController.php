<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Account;
use App\Models\Currency;
use App\Models\Expense;
use App\Models\Log;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Variable;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:expenses.read')->only(['index', 'show']);
        $this->middleware('permission:expenses.create')->only(['new', 'create']);
        $this->middleware('permission:expenses.update')->only(['edit', 'update']);
        $this->middleware('permission:expenses.delete')->only('destroy');
    }

    public function index()
    {
        $expenses = Expense::select('id', 'title', 'type', 'date', 'user_id', 'amount', 'currency_id')->filter()->orderBy('id', 'desc')->paginate(25);
        $users = User::select('id', 'name')->get();
        $currencies = Currency::select('id', 'code')->get();
        $types = Helper::get_expense_types();

        $data = compact('expenses', 'users', 'currencies', 'types');
        return view('expenses.index', $data);
    }

    public function new()
    {
        $currencies = Currency::select('id', 'code')->get();
        $types = Helper::get_expense_types();

        $data = compact('currencies', 'types');
        return view('expenses.new', $data);
    }

    public function create(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required',
            'date' => 'required|date',
            'amount' => 'required|numeric|min:0',
            'currency_id' => 'required',
            'description' => 'nullable',
        ]);

        // Create the expense record
        $expense = Expense::create([
            'title' => $request->title,
            'type' => $request->type,
            'currency_id' => $request->currency_id,
            'amount' => $request->amount,
            'date' => $request->date,
            'description' => $request->description,
            'user_id' => auth()->id(),
        ]);

        $transactionsString = '';

        // Expense Account (Debit)
        $expense_account = Account::findOrFail(Variable::where('title', 'expense_account')->first()->value);
        $transaction = Transaction::create([
            'user_id' => auth()->id(),
            'account_id' => $expense_account->id,
            'currency_id' => $request->currency_id,
            'debit' => $request->amount,
            'credit' => 0,
            'balance' => $request->amount,
            'title' => 'Expense Recorded',
            'description' => "Expense recorded for '{$expense->title}' on {$expense->date}",
        ]);
        $transactionsString .= "{$transaction->id}|";

        // Cash Account (Credit)
        $cash_account = Account::findOrFail(Variable::where('title', 'cash_account')->first()->value);
        $transaction = Transaction::create([
            'user_id' => auth()->id(),
            'account_id' => $cash_account->id,
            'currency_id' => $request->currency_id,
            'debit' => 0,
            'credit' => $request->amount,
            'balance' => -$request->amount,
            'title' => 'Cash Outflow for Expense',
            'description' => "Cash outflow for expense '{$expense->title}' on {$expense->date}",
        ]);
        $transactionsString .= "{$transaction->id}|";

        $expense->update([
            'transactions' => $transactionsString,
        ]);

        // Log the creation
        $text = ucwords(auth()->user()->name) . " created new Expense: " . $expense->title . ", datetime: " . now();
        Log::create(['text' => $text]);

        return redirect()->route('expenses')->with('success', 'Expense created successfully!');
    }

    public function edit(Expense $expense)
    {
        $types = Helper::get_expense_types();

        $data = compact('expense', 'types');
        return view('expenses.edit', $data);
    }

    public function update(Expense $expense, Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required',
            'date' => 'required|date',
            'description' => 'nullable',
        ]);

        $expense->update(
            $request->all()
        );

        $text = ucwords(auth()->user()->name) . ' updated Expense ' . $expense->name . ", datetime :   " . now();

        Log::create(['text' => $text]);

        return redirect()->route('expenses')->with('warning', 'Expense updated successfully!');
    }

    public function destroy(Expense $expense)
    {
        if ($expense->can_delete()) {
            $text = ucwords(auth()->user()->name) . " deleted Expense : " . $expense->name . ", datetime :   " . now();

            if ($expense->transactions) {
                foreach (explode('|', $expense->transactions) as $id) {
                    if ($id != '') {
                        Transaction::find($id)->delete();
                    }
                }
            }

            Log::create(['text' => $text]);
            $expense->delete();

            return redirect()->back()->with('error', 'Expense deleted successfully!');
        } else {
            return redirect()->back()->with('error', 'Unable to delete...');
        }
    }

    public function show(Expense $expense)
    {
        return view('expenses.show', compact('expense'));
    }
}
