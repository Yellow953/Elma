<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Log;
use App\Models\Supplier;
use App\Models\Variable;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:suppliers.read')->only('index');
        $this->middleware('permission:suppliers.create')->only(['new', 'create']);
        $this->middleware('permission:suppliers.update')->only(['edit', 'update']);
        $this->middleware('permission:suppliers.delete')->only('destroy');
        $this->middleware('permission:suppliers.export')->only('export');
    }

    public function index()
    {
        $suppliers = Supplier::select('id', 'name', 'email', 'phone', 'contact_person', 'address', 'tax_id', 'vat_number', 'currency_id', 'account_id')->filter()->orderBy('id', 'desc')->paginate(25);

        return view('suppliers.index', compact('suppliers'));
    }

    public function new()
    {
        return view('suppliers.new');
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255|unique:suppliers',
            'email' => 'required|email|max:255|unique:suppliers',
            'phone' => 'required|max:255',
            'vat_number' => 'required|max:255|unique:suppliers',
            'tax_id' => 'required',
            'currency_id' => 'required',
        ]);

        $payable_account = Account::find(Variable::where('title', 'payable_account')->first()->value);
        $account = Account::create([
            'account_number' => Account::generate_account_number($payable_account->account_number),
            'account_description' => 'Account for supplier ' . $request->name,
            'type' => 'P/L',
            'currency_id' => $request->currency_id,
        ]);

        $supplier = Supplier::create([
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'contact_person' => $request->contact_person,
            'phone' => $request->phone,
            'country' => $request->country,
            'vat_number' => $request->vat_number,
            'tax_id' => $request->tax_id,
            'currency_id' => $request->currency_id,
            'account_id' => $account->id,
            'payable_account_id' => $payable_account->id,
        ]);

        $text = ucwords(auth()->user()->name) . " created new Supplier : " . $supplier->name . " and his account: " . $account->account_number . ", datetime :   " . now();
        Log::create(['text' => $text]);

        return redirect()->route('suppliers')->with('success', 'Supplier created successfully!');
    }

    public function edit(Supplier $supplier)
    {
        return view('suppliers.edit', compact('supplier'));
    }

    public function update(Supplier $supplier, Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'phone' => ['required', 'max:255'],
            'vat_number' => ['required', 'max:255'],
            'tax_id' => 'required',
            'currency_id' => 'required',
        ]);

        if ($supplier->name != trim($request->name)) {
            $text = ucwords(auth()->user()->name) . ' updated Supplier ' . $supplier->name . " to " . $request->name . ", datetime :   " . now();
        } else {
            $text = ucwords(auth()->user()->name) . ' updated Supplier ' . $supplier->name . ", datetime :   " . now();
        }

        $supplier->update(
            $request->all()
        );

        Log::create(['text' => $text]);

        return redirect()->route('suppliers')->with('warning', 'Supplier updated successfully!');
    }

    public function destroy(Supplier $supplier)
    {
        if ($supplier->can_delete()) {
            $text = ucwords(auth()->user()->name) . " deleted supplier : " . $supplier->name . ", datetime :   " . now();

            Log::create(['text' => $text]);
            $supplier->delete();

            return redirect()->back()->with('error', 'Supplier deleted successfully!');
        } else {
            return redirect()->back()->with('error', 'Unothorized Access...');
        }
    }

    public function statement(Supplier $supplier)
    {
        $account = $supplier->account;

        $total_debit = 0;
        $total_credit = 0;
        $total_balance = 0;

        foreach ($supplier->transactions as $transaction) {
            $total_debit += $transaction->debit;
            $total_credit += $transaction->credit;
            $total_balance += $transaction->balance;
        }

        $data = compact('supplier', 'account', 'total_debit', 'total_credit', 'total_balance');

        return view('suppliers.statement', $data);
    }
}
