<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Invoice;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:statistics.all');
    }

    public function index()
    {
        return view('statistics.index');
    }

    public function monthly_report(Request $request)
    {
        $request->validate([
            'month' => 'required',
            'year' => 'required|numeric|min:2020'
        ]);

        $total_revenue = 0;
        $total_expenses = 0;
        $total_profit = 0;

        $month = date('m', strtotime($request->month));
        $year = $request->year;

        $invoices = Invoice::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->with('client', 'shipment', 'items')
            ->get();

        foreach ($invoices as $invoice) {
            $stats = $invoice->stats();

            $total_expenses += $stats[0];
            $total_revenue += $stats[1];
            $total_profit += $stats[2];
        }

        $data = [
            'invoices' => $invoices,
            'month' => $request->month,
            'year' => $year,
            'total_revenue' => $total_revenue,
            'total_expenses' => $total_expenses,
            'total_profit' => $total_profit,
        ];
        return view('statistics.monthly_report', $data);
    }

    public function net_profit(Request $request)
    {
        $request->validate([
            'month' => 'required',
            'year' => 'required|numeric|min:2020'
        ]);

        $total_revenue = 0;
        $total_expenses = 0;
        $internal_expenses = 0;
        $total_profit = 0;
        $net_profit = 0;

        $month = date('m', strtotime($request->month));
        $year = $request->year;

        $invoices = Invoice::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->with('client', 'shipment', 'items')
            ->get();

        foreach ($invoices as $invoice) {
            $stats = $invoice->stats();

            $total_expenses += $stats[0];
            $total_revenue += $stats[1];
            $total_profit += $stats[2];
        }

        $expenses = Expense::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->get();

        $internal_expenses = $expenses->sum('amount');
        $net_profit = $total_profit - $internal_expenses;

        $data = [
            'invoices' => $invoices,
            'expenses' => $expenses,
            'month' => $request->month,
            'year' => $year,
            'total_revenue' => $total_revenue,
            'total_expenses' => $total_expenses,
            'internal_expenses' => $internal_expenses,
            'total_profit' => $total_profit,
            'net_profit' => $net_profit,
        ];
        return view('statistics.net_profit', $data);
    }
}
