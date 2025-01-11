<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\User;
use App\Models\Supplier;
use App\Models\Client;
use App\Models\Invoice;
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
        $total_receipts = Receipt::count();
        $total_invoices = Invoice::count();

        $data = compact('total_users', 'total_suppliers', 'total_clients', 'total_sales_orders', 'total_purchase_orders', 'total_items', 'total_receipts', 'total_invoices');

        return view('statistics.index', $data);
    }
}
