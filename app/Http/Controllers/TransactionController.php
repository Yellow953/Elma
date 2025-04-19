<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:transactions.read')->only(['index', 'show']);
        $this->middleware('permission:transactions.create')->only(['new', 'create']);
        $this->middleware('permission:transactions.update')->only(['edit', 'update']);
        $this->middleware('permission:transactions.delete')->only(['destroy', 'item_destroy']);
    }

    public function index()
    {
        $transactions = Transaction::select('id', 'title', 'description', 'credit', 'debit', 'balance', 'currency_id')->filter()->orderBy('id', 'desc')->paginate(25);

        $data = compact('transactions');
        return view('transactions.index', $data);
    }

    public function edit(Transaction $transaction)
    {
        $data = compact('transaction');
        return view('transactions.edit', $data);
    }

    public function update(Transaction $transaction, Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'credit' => 'required|numeric|min:0',
            'debit' => 'required|numeric|min:0',
            'balance' => 'required|numeric',
        ]);

        $transaction->update([
            'title' => $request->title,
            'description' => $request->description,
            'credit' => $request->credit,
            'debit' => $request->debit,
            'balance' => $request->balance,
        ]);

        $text = ucwords(auth()->user()->name) . ' updated Transaction ' . $transaction->id . ", datetime :   " . now();
        Log::create(['text' => $text]);

        return redirect()->back()->with('warning', 'Invoice updated successfully!');
    }

    public function destroy(Transaction $transaction)
    {
        if ($transaction->can_delete()) {
            $text = ucwords(auth()->user()->name) . " deleted Transaction : " . $transaction->id . ", datetime :   " . now();

            Log::create(['text' => $text]);
            $transaction->delete();

            return redirect()->back()->with('error', 'Transaction deleted successfully!');
        } else {
            return redirect()->back()->with('error', 'Unable to delete...');
        }
    }
}
