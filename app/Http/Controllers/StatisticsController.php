<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\User;
use App\Models\Supplier;
use App\Models\Client;
use App\Models\Company;
use App\Models\Invoice;
use App\Models\JournalVoucher;
use App\Models\SalesOrder;
use App\Models\PurchaseOrder;
use App\Models\Receipt;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:statistics.all');
    }

    public function index()
    {
        $total_users = User::count();
        $total_suppliers = Supplier::count();
        $total_clients = Client::count();
        $total_sales_orders = SalesOrder::count();
        $total_purchase_orders = PurchaseOrder::count();
        $total_items = Item::count();
        $total_jvs = JournalVoucher::count();
        $total_receipts = Receipt::count();
        $total_invoices = Invoice::count();

        $data = compact('total_users', 'total_suppliers', 'total_clients', 'total_sales_orders', 'total_purchase_orders', 'total_items', 'total_jvs', 'total_receipts', 'total_invoices');

        return view('statistics.index', $data);
    }

    public function topSellingProducts()
    {
        $currentMonth = Carbon::now()->startOfMonth();
        $previousMonth = Carbon::now()->subMonth()->startOfMonth();

        $currentMonthData = DB::table('invoice_items')
            ->join('items', 'invoice_items.item_id', '=', 'items.id')
            ->select('items.itemcode', DB::raw('SUM(invoice_items.quantity) as total_quantity_sold'))
            ->where('invoice_items.created_at', '>=', $currentMonth)
            ->groupBy('items.itemcode')
            ->orderBy('total_quantity_sold', 'desc')
            ->take(10)
            ->get();

        $previousMonthData = DB::table('invoice_items')
            ->join('items', 'invoice_items.item_id', '=', 'items.id')
            ->select('items.itemcode', DB::raw('SUM(invoice_items.quantity) as total_quantity_sold'))
            ->where('invoice_items.created_at', '>=', $previousMonth)
            ->where('invoice_items.created_at', '<', $currentMonth)
            ->groupBy('items.itemcode')
            ->orderBy('total_quantity_sold', 'desc')
            ->take(10)
            ->get();

        // Combine data for the top 10 items
        $labels = $currentMonthData->pluck('itemcode')->merge($previousMonthData->pluck('itemcode'))->unique();

        $currentMonthDataMap = $currentMonthData->pluck('total_quantity_sold', 'itemcode');
        $previousMonthDataMap = $previousMonthData->pluck('total_quantity_sold', 'itemcode');

        $currentMonthDataArray = [];
        $previousMonthDataArray = [];

        foreach ($labels as $label) {
            $currentMonthDataArray[] = $currentMonthDataMap->get($label, 0);
            $previousMonthDataArray[] = $previousMonthDataMap->get($label, 0);
        }

        return response()->json([
            'labels' => $labels,
            'currentMonthData' => $currentMonthDataArray,
            'previousMonthData' => $previousMonthDataArray
        ]);
    }

    public function monthlyTurnoverRatio()
    {
        $currentYear = Carbon::now()->year;
        $turnoverData = DB::table('invoice_items')
            ->select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('SUM(quantity * unit_price) as cogs'),
                DB::raw('(SELECT AVG(quantity) FROM items) as average_inventory')
            )
            ->whereYear('created_at', $currentYear)
            ->groupBy(DB::raw('DATE_FORMAT(created_at, "%Y-%m")'))
            ->orderBy('month')
            ->get();

        $labels = $turnoverData->pluck('month');
        $data = $turnoverData->map(function ($item) {
            return $item->average_inventory > 0 ? $item->cogs / $item->average_inventory : 0;
        });

        return response()->json([
            'labels' => $labels,
            'data' => $data
        ]);
    }

    public function stockOutAnalysis()
    {
        $currentYear = Carbon::now()->year;
        $stockOutData = DB::table('s_o_items')
            ->select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('COUNT(*) as stock_out_count')
            )
            ->whereYear('created_at', $currentYear)
            ->groupBy(DB::raw('DATE_FORMAT(created_at, "%Y-%m")'))
            ->orderBy('month')
            ->get();

        return response()->json($stockOutData);
    }

    public function stockInAnalysis()
    {
        $currentYear = Carbon::now()->year;
        $stockInData = DB::table('p_o_items')
            ->select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('COUNT(*) as stock_in_count')
            )
            ->whereYear('created_at', $currentYear)
            ->groupBy(DB::raw('DATE_FORMAT(created_at, "%Y-%m")'))
            ->orderBy('month')
            ->get();

        return response()->json($stockInData);
    }

    public function deadStockAnalysis()
    {
        $sixMonthsAgo = Carbon::now()->subMonths(6);

        $totalInventory = DB::table('items')
            ->count();

        $deadStock = DB::table('items')
            ->leftJoin('invoice_items', 'items.id', '=', 'invoice_items.item_id')
            ->where(function ($query) use ($sixMonthsAgo) {
                $query->whereNull('invoice_items.created_at')
                    ->orWhere('invoice_items.created_at', '<', $sixMonthsAgo);
            })
            ->distinct('items.id')
            ->count('items.id');

        return response()->json([
            'total_inventory' => $totalInventory,
            'dead_stock' => $deadStock,
            'active_stock' => $totalInventory - $deadStock,
        ]);
    }

    public function demandForecasting()
    {
        // Fetch actual sales data for the last 12 months
        $actualSales = DB::table('invoice_items')
            ->select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'), DB::raw('SUM(quantity) as total_sales'))
            ->groupBy(DB::raw('DATE_FORMAT(created_at, "%Y-%m")'))
            ->orderBy(DB::raw('DATE_FORMAT(created_at, "%Y-%m")'))
            ->get();

        $monthly_growth_factor = Company::first()->monthly_growth_factor;
        $forecastedDemand = $actualSales->map(function ($sale, $monthly_growth_factor) {
            return [
                'month' => $sale->month,
                'forecasted_sales' => $sale->total_sales * $monthly_growth_factor,
            ];
        });

        // Fetch sales forecast by product for the last 12 months
        $salesForecastByProduct = DB::table('invoice_items')
            ->join('items', 'invoice_items.item_id', '=', 'items.id')
            ->select(DB::raw('DATE_FORMAT(invoice_items.created_at, "%Y-%m") as month'), 'items.itemcode', DB::raw('SUM(invoice_items.quantity) as total_sales'))
            ->groupBy('items.itemcode', DB::raw('DATE_FORMAT(invoice_items.created_at, "%Y-%m")'))
            ->orderBy(DB::raw('DATE_FORMAT(invoice_items.created_at, "%Y-%m")'))
            ->get();

        return response()->json([
            'actual_sales' => $actualSales,
            'forecasted_demand' => $forecastedDemand,
            'sales_forecast_by_product' => $salesForecastByProduct
        ]);
    }

    public function revenueExpenses()
    {
        $startDate = Carbon::now()->subYear()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();

        // Calculate monthly revenue by summing up the total price of invoice items
        $revenue = DB::table('invoice_items')
            ->select(DB::raw('DATE_FORMAT(invoices.created_at, "%Y-%m") as month'), DB::raw('SUM(invoice_items.total_price) as revenue'))
            ->join('invoices', 'invoices.id', '=', 'invoice_items.invoice_id')
            ->whereBetween('invoices.created_at', [$startDate, $endDate])
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Calculate monthly expenses by summing up the total cost of purchase order items
        $expenses = DB::table('v_o_c_items')
            ->select(DB::raw('DATE_FORMAT(v_o_c_s.created_at, "%Y-%m") as month'), DB::raw('SUM(v_o_c_items.amount) as expense'))
            ->join('v_o_c_s', 'v_o_c_s.id', '=', 'v_o_c_items.voc_id')
            ->whereBetween('v_o_c_s.created_at', [$startDate, $endDate])
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return response()->json([
            'revenue' => $revenue,
            'expenses' => $expenses,
        ]);
    }

    public function topCustomersSuppliers()
    {
        // Fetch top customers based on transactions
        $topCustomers = Client::with(['account.transactions' => function ($query) {
            $query->select('account_id', DB::raw('SUM(debit) as total_sales'))
                ->groupBy('account_id');
        }])
            ->get()
            ->map(function ($client) {
                $client->total_sales = $client->account->transactions->sum('total_sales');
                return $client;
            })
            ->sortByDesc('total_sales')
            ->take(10)
            ->values();

        // Fetch top suppliers based on transactions
        $topSuppliers = Supplier::with(['account.transactions' => function ($query) {
            $query->select('account_id', DB::raw('SUM(credit) as total_purchases'))
                ->groupBy('account_id');
        }])
            ->get()
            ->map(function ($supplier) {
                $supplier->total_purchases = $supplier->account->transactions->sum('total_purchases');
                return $supplier;
            })
            ->sortByDesc('total_purchases')
            ->take(10)
            ->values();

        return response()->json([
            'topCustomers' => $topCustomers,
            'topSuppliers' => $topSuppliers,
        ]);
    }

    public function receivablesDistribution()
    {
        $receivables = Client::with('account.transactions')
            ->get()
            ->map(function ($client) {
                $client->total_receivables = $client->account->transactions->sum('debit');
                return $client;
            })
            ->filter(function ($client) {
                return $client->total_receivables > 0;
            })
            ->values();

        return response()->json([
            'receivables' => $receivables,
        ]);
    }

    public function payablesDistribution()
    {
        $payables = Supplier::with('account.transactions')
            ->get()
            ->map(function ($supplier) {
                $supplier->total_payables = $supplier->account->transactions->sum('credit');
                return $supplier;
            })
            ->filter(function ($supplier) {
                return $supplier->total_payables > 0;
            })
            ->values();

        return response()->json([
            'payables' => $payables,
        ]);
    }

    public function netProfitMargin()
    {
        $startDate = Carbon::now()->subYear()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();

        $revenue = DB::table('invoice_items')
            ->select(DB::raw('DATE_FORMAT(invoice_items.created_at, "%Y-%m") as month'), DB::raw('SUM(invoice_items.unit_price * invoice_items.quantity) as total_revenue'))
            ->join('invoices', 'invoices.id', '=', 'invoice_items.invoice_id')
            ->whereBetween('invoices.created_at', [$startDate, $endDate])
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->keyBy('month');

        $expenses = DB::table('invoice_items')
            ->select(DB::raw('DATE_FORMAT(invoice_items.created_at, "%Y-%m") as month'), DB::raw('SUM(invoice_items.unit_cost * invoice_items.quantity) as total_expense'))
            ->join('invoices', 'invoices.id', '=', 'invoice_items.invoice_id')
            ->whereBetween('invoices.created_at', [$startDate, $endDate])
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->keyBy('month');

        $netProfitMargin = [];
        foreach ($revenue as $month => $rev) {
            $expense = $expenses[$month]->total_expense ?? 0;
            $netProfit = $rev->total_revenue - $expense;
            $netProfitMargin[$month] = $rev->total_revenue > 0 ? ($netProfit / $rev->total_revenue) * 100 : 0;
        }

        return response()->json($netProfitMargin);
    }

    public function stockValuation()
    {
        $startDate = Carbon::now()->subYear()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();

        $stockValuation = DB::table('items')
            ->select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'), DB::raw('SUM(quantity * unit_cost) as total_valuation'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('total_valuation', 'month');

        return response()->json($stockValuation);
    }
}
