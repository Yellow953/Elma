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
        $this->middleware('permission:currencies.read')->only('index');
        $this->middleware('permission:currencies.create')->only(['new', 'create']);
        $this->middleware('permission:currencies.update')->only(['edit', 'update']);
        $this->middleware('permission:currencies.delete')->only('destroy');
        $this->middleware('permission:currencies.export')->only('export');
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

    public function switch(Currency $currency)
    {
        auth()->user()->update([
            'currency_id' => $currency->id,
        ]);

        return redirect()->back()->with('success', 'Currency switched to ' . $currency->name);
    }
}
