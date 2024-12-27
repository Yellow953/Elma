<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Warehouse;

class LogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('setup');
        $this->middleware('agreed');
    }

    public function index()
    {
        $logs = Log::select('text')->filter()->orderBy('id', 'desc')->paginate(25);

        $data = compact('logs');
        return view('logs.index', $data);
    }

    public function IndividualLogs($warehouse)
    {
        $current = $warehouse;
        $logs = Log::select('text')->where('text', 'LIKE', "%{$current}%")->filter()->orderBy('id', 'desc')->paginate(25);
        $warehouse = Warehouse::where('name', $warehouse)->firstOrFail();

        $data = compact('logs', 'warehouse');
        return view('logs.index', $data);
    }
}
