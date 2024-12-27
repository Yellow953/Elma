<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Log;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:settings.all');
    }

    public function new()
    {
        return view('settings.new');
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'address' => 'required',
            'monthly_growth_factor' => 'numeric|min:0|required',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = time() . '.' . $ext;
            $file->move('uploads/company/', $filename);
            $path = '/uploads/company/' . $filename;
        }

        Company::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'vat_number' => $request->vat_number,
            'website' => $request->website,
            'logo' => $path ?? null,
            'allow_past_dates' => $request->boolean('allow_past_dates'),
            'monthly_growth_factor' => $request->monthly_growth_factor,
        ]);

        Log::create([
            'text' => auth()->user()->name . ' completed the setup, datetime: ' . now(),
        ]);

        return redirect()->route('dashboard')->with('success', 'Settings saved.');
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'address' => 'required',
        ]);

        $company = Company::first();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = time() . '.' . $ext;
            $file->move('uploads/company/', $filename);
            $path = '/uploads/company/' . $filename;
        } else {
            $path = $company->logo;
        }

        $company->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'vat_number' => $request->vat_number,
            'website' => $request->website,
            'logo' => $path,
            'monthly_growth_factor' => $request->monthly_growth_factor,
        ]);

        Log::create([
            'text' => auth()->user()->name . ' changed the Company settings, datetime: ' . now(),
        ]);

        return redirect()->back()->with('success', 'Company Settings saved.');
    }

    public function toggle_allow_past_dates(Request $request)
    {
        $company = Company::first();
        if ($company->allow_past_dates) {
            $company->update(['allow_past_dates' => false]);
            return redirect()->back()->with('success', 'Past Dates Disabled...');
        } else {
            $company->update(['allow_past_dates' => true]);
            return redirect()->back()->with('success', 'Past Dates Enabled...');
        }
    }
}
