<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Log;
use App\Models\Tax;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TaxController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('setup');
        $this->middleware('agreed');
        $this->middleware('admin')->except('get_rate');
    }

    public function index()
    {
        $accounts = Account::select('id', 'account_number', 'account_description')->get();
        $taxes = Tax::select('id', 'name', 'rate', 'account_id')->filter()->paginate(25);
        $data = compact('taxes', 'accounts');

        return view('taxes.index', $data);
    }

    public function new()
    {
        $accounts = Account::select('id', 'account_number', 'account_description')->get();
        return view('taxes.new', compact('accounts'));
    }

    public function create(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|unique:taxes',
            'account_id' => 'required|numeric|min:0',
            'rate' => 'required|numeric|min:0|max:100',
        ]);

        $tax =  Tax::create($data);

        $text = ucwords(auth()->user()->name) . " created new Tax : " . $tax->name . ", datetime :   " . now();
        Log::create(['text' => $text]);

        return redirect()->route('taxes')->with('success', 'Tax created successfully!');
    }

    public function edit(Tax $tax)
    {
        $accounts = Account::select('id', 'account_number', 'account_description')->get();
        $data = compact('tax', 'accounts');

        return view('taxes.edit', $data);
    }

    public function update(Tax $tax, Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'account_id' => 'required|numeric|min:0',
            'rate' => 'required|numeric|min:0|max:100'
        ]);

        $text = "Tax: " . $tax->name . " changed to " . $request->rate . " in " . Carbon::now();

        $tax->update($data);
        Log::create(['text' => $text]);

        return redirect()->back()->with('success', 'Tax successfully changed');
    }

    public function destroy(Tax $tax)
    {
        if ($tax->can_delete()) {
            $text = ucwords(auth()->user()->name) . " deleted Tax : " . $tax->name . ", datetime :   " . now();

            Log::create(['text' => $text]);
            $tax->delete();

            return redirect()->back()->with('error', 'Tax deleted successfully!');
        } else {
            return redirect()->back()->with('error', 'Unothorized Access...');
        }
    }
}
