<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function show()
    {
        $user = auth()->user();

        $data = compact('user');
        return view('profile.show', $data);
    }

    public function edit()
    {
        $user = auth()->user();

        $data = compact('user');
        return view('profile.edit', $data);
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'currency_id' => 'required|numeric',
        ]);

        $user = auth()->user();

        $user->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'currency_id' => $request->currency_id,
        ]);

        return redirect()->route('profile')->with('success', 'Profile Updated Successfully');
    }

    public function SavePassword(Request $request)
    {
        $user = auth()->user();

        if ($request->newpassword == $request->confirmpassword) {
            $user->password = Hash::make($request->newpassword);
            $user->save();
        }

        return redirect()->route('profile')->with('success', 'Password Updated Successfully');
    }
}
