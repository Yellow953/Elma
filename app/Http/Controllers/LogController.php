<?php

namespace App\Http\Controllers;

use App\Models\Log;

class LogController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:logs.read')->only('index');
        $this->middleware('permission:logs.export')->only('export');
    }

    public function index()
    {
        $logs = Log::select('text')->filter()->orderBy('id', 'desc')->paginate(25);

        $data = compact('logs');
        return view('logs.index', $data);
    }
}
