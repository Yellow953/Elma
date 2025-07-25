<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
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
    }

    public function index()
    {
        $suppliers = Supplier::select('id', 'name', 'email', 'phone', 'address', 'tax_id', 'vat_number', 'currency_id', 'account_id')->filter()->orderBy('id', 'desc')->paginate(25);

        return view('suppliers.index', compact('suppliers'));
    }

    public function new()
    {
        $currencies = Helper::get_currencies();
        $taxes = Helper::get_taxes();

        $data = compact('currencies', 'taxes');
        return view('suppliers.new', $data);
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255|unique:suppliers',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|max:255',
            'vat_number' => 'nullable|max:255',
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
            'phone' => $request->phone,
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
        $currencies = Helper::get_currencies();
        $taxes = Helper::get_taxes();

        $data = compact('currencies', 'taxes', 'supplier');
        return view('suppliers.edit', $data);
    }

    public function update(Supplier $supplier, Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|max:255',
            'vat_number' => 'nullable|max:255',
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
        $transactions = $supplier->transactions()->orderBy('created_at', 'ASC')->get();
        $total = 0;

        $data = compact('supplier', 'account', 'transactions', 'total');
        return view('suppliers.statement', $data);
    }
}
