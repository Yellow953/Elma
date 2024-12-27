<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\Log;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('setup');
        $this->middleware('agreed');
        $this->middleware('admin')->except('switch', 'get_exchange_rate');
    }

    public function index()
    {
        $currencies = Currency::select('id', 'code', 'name', 'symbol', 'rate')->get();
        return view('currencies.index', compact('currencies'));
    }

    public function edit(Currency $currency)
    {
        return view('currencies.edit', compact('currency'));
    }

    public function update(Currency $currency, Request $request)
    {
        $data = $request->validate([
            'code' => 'required',
            'name' => 'required',
            'symbol' => 'required',
            'rate' => 'required|numeric'
        ]);

        $currency->update($data);

        $text = "Currency " . $currency->name . " changed to " . $currency->rate . " in " . Carbon::now();

        Log::create(['text' => $text]);
        return redirect()->route('currencies')->with('success', 'Currency successfully updated...');
    }

    public function switch(Request $request)
    {
        $request->validate([
            'currency_id' => 'required|exists:currencies,id',
        ]);

        $currency = Currency::find($request->input('currency_id'));

        $user = User::find(auth()->user()->id);
        $user->update([
            'currency_id' => $currency->id,
        ]);

        return redirect()->back()->with('success', 'Currency switched to ' . $currency->name);
    }
}
