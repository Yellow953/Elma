<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\User;
use App\Models\Supplier;
use App\Models\Client;
use App\Models\SalesOrder;
use App\Models\Invoice;
use App\Models\PurchaseOrder;
use App\Models\Receipt;
use App\Models\SearchRoute;
use App\Models\Shipment;
use App\Models\Payment;
use App\Models\Expense;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public function index()
    {
        $total_users = User::count();
        $total_suppliers = Supplier::count();
        $total_clients = Client::count();
        $total_shipments = Shipment::count();
        $total_sales_orders = SalesOrder::count();
        $total_purchase_orders = PurchaseOrder::count();
        $total_items = Item::count();
        $total_receipts = Receipt::count();
        $total_invoices = Invoice::count();
        $total_payments = Payment::count();
        $total_expenses = Expense::count();

        $data = compact('total_users', 'total_suppliers', 'total_clients', 'total_shipments', 'total_sales_orders', 'total_purchase_orders', 'total_items', 'total_receipts', 'total_invoices', 'total_payments', 'total_expenses');
        return view('dashboard', $data);
    }

    public function custom_logout()
    {
        Session::flush();
        Auth::logout();
        return redirect('login');
    }

    public function navigate(Request $request)
    {
        $res = SearchRoute::where('name', $request->route)->first();
        if (!$res) {
            return response()->json(['error' => 'Route not found'], 404);
        } else {
            return redirect()->route($res->link);
        }
    }

    public function fix()
    {
        return 'fixed...';
    }
}
