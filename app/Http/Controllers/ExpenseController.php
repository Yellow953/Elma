<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\Expense;
use App\Models\Log;
use App\Models\User;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:expenses.read')->only(['index', 'show']);
        $this->middleware('permission:expenses.create')->only(['new', 'create']);
        $this->middleware('permission:expenses.update')->only(['edit', 'update']);
        $this->middleware('permission:expenses.delete')->only('destroy');
        $this->middleware('permission:expenses.export')->only('export');
    }

    public function index()
    {
        $expenses = Expense::select('id', 'title', 'type', 'date', 'user_id', 'amount', 'currency_id')->filter()->orderBy('id', 'desc')->paginate(25);
        $users = User::select('id', 'name')->get();
        $currencies = Currency::select('id', 'name')->get();

        $data = compact('expenses', 'users', 'currencies');
        return view('expenses.index', $data);
    }

    public function new()
    {
        $users = User::select('id', 'name')->get();
        $currencies = Currency::select('id', 'name')->get();

        $data = compact('users', 'currencies');
        return view('expenses.new', $data);
    }

    public function create(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required',
            'date' => 'required|date',
            'user_id' => 'required',
            'amount' => 'required|numeric|min:0',
            'currency_id' => 'required',
            'description' => 'nullable',
        ]);

        $expense = Expense::create(
            $request->all()
        );

        // Log the creation
        $text = ucwords(auth()->user()->name) . " created new Expense: " . $expense->title . ", datetime: " . now();
        Log::create(['text' => $text]);

        return redirect()->route('expenses')->with('success', 'Expense created successfully!');
    }

    public function edit(Expense $expense)
    {
        $users = User::select('id', 'name')->get();
        $currencies = Currency::select('id', 'name')->get();

        $data = compact('expense', 'users', 'currencies');
        return view('expenses.edit', $data);
    }

    public function update(Expense $expense, Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required',
            'date' => 'required|date',
            'user_id' => 'required',
            'amount' => 'required|numeric|min:0',
            'currency_id' => 'required',
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
        $text = ucwords(auth()->user()->name) . " deleted Expense : " . $expense->name . ", datetime :   " . now();

        Log::create(['text' => $text]);
        $expense->delete();

        return redirect()->back()->with('error', 'Expense deleted successfully!');
    }

    public function show(Expense $expense)
    {
        return view('expenses.show', compact('expense'));
    }
}
