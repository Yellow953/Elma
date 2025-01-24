<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Log;
use App\Models\Variable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $receivable_account = Variable::where('title', 'receivable_account')->first();
        $payable_account = Variable::where('title', 'payable_account')->first();
        $cash_account = Variable::where('title', 'cash_account')->first();
        $accounts = Account::select('id', 'account_number', 'account_description')->get();
        $ports = Variable::select('id', 'title')->where('type', 'ports')->get();

        $data = compact('accounts', 'expense_account', 'revenue_account', 'receivable_account', 'payable_account', 'cash_account', 'ports');
        return view('settings.index', $data);
    }

    public function update(Request $request)
    {
        $request->validate([
            'expense_account_id' => 'required',
            'revenue_account_id' => 'required',
            'receivable_account_id' => 'required',
            'payable_account_id' => 'required',
            'cash_account_id' => 'required',
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

        if ($request->receivable_account_id) {
            Variable::where('name', 'receivable_account')->first()->update([
                'value' => $request->receivable_account_id
            ]);
        }

        if ($request->payable_account_id) {
            Variable::where('name', 'payable_account')->first()->update([
                'value' => $request->payable_account_id
            ]);
        }

        if ($request->cash_account_id) {
            Variable::where('name', 'cash_account')->first()->update([
                'value' => $request->cash_account_id
            ]);
        }

        return redirect()->back()->with('success', 'Configurations updated successfully...');
    }

    public function port_create(Request $request)
    {
        $request->validate([
            'port' => 'required|string|max:255',
        ]);

        Variable::create([
            'type' => 'ports',
            'title' => $request->port,
            'value' => $request->port,
        ]);

        $text = ucwords(auth()->user()->name) . " created Port : " . $request->port . ", datetime :   " . now();

        Log::create(['text' => $text]);

        return redirect()->back()->with('success', 'Port created successfully!');
    }

    public function port_destroy($id)
    {
        $port = Variable::findOrFail($id);

        $text = ucwords(auth()->user()->name) . " deleted Port : " . $port->title . ", datetime :   " . now();

        Log::create(['text' => $text]);
        $port->delete();

        return redirect()->back()->with('error', 'Port deleted successfully!');
    }

    public function export()
    {
        $filePath = public_path('backups/database_backup.sql');

        exec('mysqldump -u' . env('DB_USERNAME') . ' -p' . env('DB_PASSWORD') . ' ' . env('DB_DATABASE') . ' > ' . $filePath);

        return response()->download($filePath)->deleteFileAfterSend(false);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimetypes:text/plain,application/octet-stream',
        ]);

        $file = $request->file('file');

        $sql = file_get_contents($file->getRealPath());

        DB::unprepared($sql);

        return redirect()->back()->with('success', 'Database imported successfully.');
    }
}
