<?php

namespace App\Http\Controllers;

use App\Exports\UserExport;
use App\Models\Log;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Maatwebsite\Excel\Facades\Excel;

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
        $users = User::select('id', 'name', 'email', 'currency_id')->filter()->orderBy('id', 'desc')->paginate(25);

        return view('users.index', compact('users'));
    }

    public function new()
    {
        $permissions = Permission::all();
        return view('users.new', compact('permissions'));
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'currency_id' => 'required',
            'password' => 'required|max:255|confirmed',
        ]);

        $user = User::create([
            'name' => trim($request->name),
            'email' => trim($request->email),
            'currency_id' => $request->currency_id,
            'password' => bcrypt($request->password),
        ]);

        if ($request->has('permissions')) {
            $user->syncPermissions($request->permissions);
        }

        $text = ucwords(auth()->user()->name) . " created User : " . $request->name . ", datetime :   " . now();
        Log::create([
            'text' => $text,
        ]);

        return redirect()->route('users')->with('success', 'User created successfully!');
    }

    public function edit(User $user)
    {
        $permissions = Permission::all();
        $userPermissions = $user->getAllPermissions()->pluck('name')->toArray();

        $data = compact('user', 'permissions', 'userPermissions');
        return view('users.edit', $data);
    }

    public function update(User $user, Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
        ]);

        $user->update([
            'name' => trim($request->name),
            'email' => trim($request->email),
        ]);

        if ($request->has('permissions')) {
            $user->syncPermissions($request->permissions);
        } else {
            $user->syncPermissions([]);
        }

        if ($user->name != trim($request->name)) {
            $text = ucwords(auth()->user()->name) . ' updated User ' . $user->name . " to " . $request->name . ", datetime :   " . now();
        } else {
            $text = ucwords(auth()->user()->name) . ' updated User ' . $user->name . ", datetime :   " . now();
        }

        Log::create([
            'text' => $text,
        ]);

        return redirect()->route('users')->with('success', 'User created successfully!');
    }

    public function destroy(User $user)
    {
        $text = ucwords(auth()->user()->name) . " deleted user : " . $user->name . ", datetime :   " . now();

        Log::create([
            'text' => $text,
        ]);
        $user->delete();

        return redirect()->back()->with('error', 'User deleted successfully!');
    }

    public function export()
    {
        return Excel::download(new UserExport, 'Users.xlsx');
    }
}
