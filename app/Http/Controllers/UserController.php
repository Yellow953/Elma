<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:users.read')->only('index');
        $this->middleware('permission:users.create')->only(['new', 'create']);
        $this->middleware('permission:users.update')->only(['edit', 'update']);
        $this->middleware('permission:users.delete')->only('destroy');
        $this->middleware('permission:users.export')->only('export');
    }

    public function index()
    {
        $users = User::select('id', 'image', 'name', 'email', 'role', 'phone',  'location_id', 'currency_id')->filter()->orderBy('id', 'desc')->paginate(25);

        return view('users.index', compact('users'));
    }

    public function new()
    {
        return view('users.new');
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'location_id' => 'required',
            'currency_id' => 'required',
            'role' => 'required',
            'password' => 'required|max:255|confirmed',
        ]);

        $user = User::create([
            'name' => trim($request->name),
            'email' => trim($request->email),
            'phone' => $request->phone,
            'image' => '/assets/images/profiles/NoProfile.png',
            'location_id' => $request->location_id,
            'currency_id' => $request->currency_id,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        $text = ucwords(auth()->user()->name) . " created admin user : " . $request->name . ", datetime :   " . now();
        Log::create(['text' => $text]);

        return redirect()->route('users')->with('success', 'Admin created successfully!');
    }

    public function destroy(User $user)
    {
        if ($user->can_delete()) {
            $text = ucwords(auth()->user()->name) . " deleted user : " . $user->name . ", datetime :   " . now();

            Log::create(['text' => $text]);
            $user->delete();

            return redirect()->back()->with('error', 'User deleted successfully!');
        } else {
            return redirect()->back()->with('error', 'Unothorized Access...');
        }
    }

    public function terms()
    {
        return view('users.terms');
    }

    public function terms_agree()
    {
        $user = User::findOrFail(Auth()->user()->id);
        $user->update(['terms_agreed' => true, 'terms_agreed_at' => now()]);

        return redirect()->route('dashboard')->with('success', 'Thank You for aggreeing on our terms and conditions, Enjoy the system!');
    }
}
