<?php

namespace App\Http\Controllers;

use App\Models\Request as ModelsRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('agreed');
    }

    public function show(User $user)
    {
        $totalIns = ModelsRequest::where('user_id', $user->id)->where('type', 1)->count();
        $totalOuts = ModelsRequest::where('user_id', $user->id)->where('type', 2)->count();

        $data = compact('user', 'totalIns', 'totalOuts');
        return view('users.show', $data);
    }

    public function edit(User $user)
    {
        $data = compact('user');
        return view('users.edit', $data);
    }

    public function update(User $user, Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'currency_id' => 'required|numeric',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = time() . '.' . $ext;
            $file->move('uploads/profiles/', $filename);
            $path = '/uploads/profiles/' . $filename;
        } else {
            $path = $user->image;
        }

        $user->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'image' => $path,
            'currency_id' => $request->currency_id,
        ]);

        return redirect()->route('profile', auth()->user()->id)->with('success', 'Profile Updated Successfully');
    }

    public function SavePassword(user $user, Request $request)
    {
        if ($request->newpassword == $request->confirmpassword) {
            $user->password = Hash::make($request->newpassword);
            $user->save();
        }

        return redirect()->route('profile', auth()->user()->id)->with('success', 'Password Updated Successfully');
    }
}
