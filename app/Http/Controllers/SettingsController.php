<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Variable;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:settings.all');
    }

    public function index()
    {
        $expense_account = Variable::where('title', 'expense_account')->first();
        $revenue_account = Variable::where('title', 'revenue_account')->first();
        $accounts = Account::select('id', 'account_number', 'account_description')->get();

        $data = compact('accounts', 'expense_account', 'revenue_account');
        return view('settings.index', $data);
    }

    public function update(Request $request)
    {
        $request->validate([
            'expense_account_id' => 'required',
        ]);

        if ($request->expense_account_id) {
            Variable::where('name', 'expense_account')->first()->update([
                'value' => $request->expense_account_id
            ]);
        }

        if ($request->revenue_account_id) {
            Variable::where('name', 'revenue_account')->first()->update([
                'value' => $request->revenue_account_id
            ]);
        }

        return redirect()->back()->with('success', 'Configurations updated successfully...');
    }
}
