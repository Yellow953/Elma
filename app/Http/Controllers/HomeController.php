<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\User;
use App\Models\Supplier;
use App\Models\Client;
use App\Models\SO;
use App\Models\Invoice;
use App\Models\JournalVoucher;
use App\Models\PO;
use App\Models\Receipt;
use App\Models\SearchRoute;
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
        $total_sos = SO::count();
        $total_pos = PO::count();
        $total_items = Item::count();
        $total_jvs = JournalVoucher::count();
        $total_receipts = Receipt::count();
        $total_invoices = Invoice::count();

        $data = compact('total_users', 'total_suppliers', 'total_clients', 'total_sos', 'total_pos', 'total_items', 'total_jvs', 'total_receipts', 'total_invoices');
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
}
