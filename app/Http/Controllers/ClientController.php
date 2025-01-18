<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Log;
use App\Models\Client;
use App\Models\Variable;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:clients.read')->only('index');
        $this->middleware('permission:clients.create')->only(['new', 'create']);
        $this->middleware('permission:clients.update')->only(['edit', 'update']);
        $this->middleware('permission:clients.delete')->only('destroy');
        $this->middleware('permission:clients.export')->only('export');
    }

    public function index()
    {
        $clients = Client::select('id', 'name', 'email', 'phone', 'address', 'tax_id', 'currency_id', 'account_id')->filter()->orderBy('id', 'desc')->paginate(25);

        return view('clients.index', compact('clients'));
    }

    public function new()
    {
        return view('clients.new');
    }

    public function create(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:255|unique:clients',
            'email' => 'required|email|max:255|unique:clients',
            'phone' => 'required|max:255',
            'address' => 'required|max:255',
            'tax_id' => 'required',
            'currency_id' => 'required',
            'vat_number' => 'required|unique:clients',
        ]);

        $receivable_account = Account::find(Variable::where('title', 'receivable_account')->first()->value);
        $account = Account::create([
            'account_number' => Account::generate_account_number($receivable_account->account_number),
            'account_description' => 'Account for client ' . $request->name,
            'type' => 'P/L',
            'currency_id' => $request->currency_id,
        ]);

        $client = Client::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'tax_id' => $request->tax_id,
            'currency_id' => $request->currency_id,
            'account_id' => $account->id,
            'receivable_account_id' => $receivable_account->id,
            'vat_number' => $request->vat_number,
        ]);

        $text = ucwords(auth()->user()->name) . " created new Client : " . $client->name . " and his account: " . $account->account_number . ", datetime :   " . now();
        Log::create(['text' => $text]);

        return redirect()->route('clients')->with('success', 'Client created successfully!');
    }

    public function edit(Client $client)
    {
        return view('clients.edit', compact('client'));
    }

    public function update(Client $client, Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'phone' => ['required', 'max:255'],
            'address' => ['required', 'max:255'],
            'tax_id' => 'required',
            'currency_id' => 'required',
            'vat_number' => 'required',
        ]);

        if ($client->name != trim($request->name)) {
            $text = ucwords(auth()->user()->name) . ' updated Client ' . $client->name . " to " . $request->name . ", datetime :   " . now();
        } else {
            $text = ucwords(auth()->user()->name) . ' updated Client ' . $client->name . ", datetime :   " . now();
        }

        $client->update(
            $request->all()
        );

        Log::create(['text' => $text]);

        return redirect()->route('clients')->with('warning', 'Client updated successfully!');
    }

    public function destroy(Client $client)
    {
        if ($client->can_delete()) {
            $text = ucwords(auth()->user()->name) . " deleted client : " . $client->name . ", datetime :   " . now();

            Log::create(['text' => $text]);
            $client->delete();

            return redirect()->back()->with('error', 'Client deleted successfully!');
        } else {
            return redirect()->back()->with('error', 'Unothorized Access...');
        }
    }

    public function statement(Client $client)
    {
        $account = $client->account;
        $transactions = $client->transactions;

        $data = compact('client', 'account', 'transactions');
        return view('clients.statement', $data);
    }
}
