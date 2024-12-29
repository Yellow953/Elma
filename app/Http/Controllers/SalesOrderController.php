<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\SalesOrder;
use App\Models\SalesOrderItem;
use App\Models\Item;
use App\Models\Log;
use App\Models\Tax;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class SalesOrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:sales_orders.read')->only('index');
        $this->middleware('permission:sales_orders.create')->only(['new', 'create']);
        $this->middleware('permission:sales_orders.update')->only(['edit', 'update']);
        $this->middleware('permission:sales_orders.delete')->only('destroy');
        $this->middleware('permission:sales_orders.export')->only('export');
    }

    public function index()
    {
        $sales_orders = SalesOrder::select('id', 'name', 'date')->filter()->orderBy('id', 'desc')->paginate(25);

        $data = compact('sales_orders');
        return view('sales_orders.index', $data);
    }

    public function new()
    {
        return view('sales_orders.new');
    }

    public function create(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
        ]);

        $sales_order = SalesOrder::create([
            'name' => SalesOrder::generate_name(),
            'description' => $request->description,
            'date' => $request->date ?? Carbon::now(),
        ]);

        $text = ucwords(auth()->user()->name) . " created " . $sales_order->name . ", datetime :   " . now();
        Log::create(['text' => $text]);

        return redirect()->route('sales_orders')->with('success', 'SalesOrder created successfully!');
    }

    public function show(SalesOrder $sales_order)
    {
        return view('sales_orders.show', compact('sales_order'));
    }

    public function display(SalesOrder $sales_order)
    {
        return view('sales_orders.display', compact('sales_order'));
    }

    public function print(SalesOrder $sales_order)
    {
        return view('sales_orders.show', compact('sales_order'));
    }

    public function edit(SalesOrder $sales_order)
    {
        $parts = explode('-', $sales_order->name);
        $search = request()->query('search');

        if ($search) {
            $item = Item::where('itemcode', 'LIKE', "%{$search}%")->firstOrFail();
            if ($item != null) {
                $sales_order_items = SalesOrderItem::select('id', 'item_id', 'quantity')->where('so_id', $sales_order->id)->where('item_id', $item->id)->paginate(50);
            } else {
                $sales_order_items = new Collection();
            }
        } else {
            $sales_order_items = SalesOrderItem::select('id', 'item_id', 'quantity')->where('so_id', $sales_order->id)->orderBy('created_at', 'asc')->paginate(50);
        }

        $data = compact('sales_order', 'sales_order_items');

        return view('sales_orders.edit', $data);
    }

    public function update(SalesOrder $sales_order, Request $request)
    {
        $request->validate([
            'date' => 'required|date',
        ]);

        $sales_order->update([
            'description' => $request->description,
            'date' => $request->date,
        ]);

        $text = ucwords(auth()->user()->name) . ' updated ' . $sales_order->name . ", datetime :   " . now();
        Log::create(['text' => $text]);

        return redirect()->route('sales_orders')->with('warning', 'SalesOrder updated successfully!');
    }

    public function activity(SalesOrder $sales_order)
    {
        $search_term1 = " " . trim($sales_order->name) . ",";
        $search_term2 = " " . trim($sales_order->name) . " ";
        $logs = Log::select('text')->where('text', 'LIKE', "%{$search_term1}%")->orWhere('text', 'LIKE', "%{$search_term2}%")->orderBy('id', 'desc')->get();

        $data = compact('sales_order', 'logs');
        return view('sales_orders.activity', $data);
    }

    public function Return(SalesOrderItem $sales_orderItem)
    {
        $item = Item::findOrFail($sales_orderItem->item_id);
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        ModelsRequest::create([
            'user_id' => auth()->user()->id,
            'item_id' => $item->id,
            'so_id' => $sales_orderItem->id,
            'quantity' => $sales_orderItem->quantity,
            'type' => 10,
            'status' => 0,
        ]);

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
        return redirect()->back()->with('info', 'Request sent!');
    }

    public function return_all($id)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        $sales_order_items = SalesOrderItem::where('so_id', $id)->get();
        foreach ($sales_order_items as $sales_orderItem) {
            $item = Item::findOrFail($sales_orderItem->item_id);

            ModelsRequest::create([
                'user_id' => auth()->user()->id,
                'item_id' => $item->id,
                'so_id' => $sales_orderItem->id,
                'quantity' => $sales_orderItem->quantity,
                'type' => 10,
                'status' => 0,
            ]);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
        return redirect()->back()->with('info', 'Requests sent!');
    }

    public function AddItems(SalesOrder $sales_order)
    {
        $parts = explode('-', $sales_order->name);

        $sales_order_items = SalesOrderItem::select('item_id', 'quantity')->where('so_id', $sales_order->id)->orderBy('created_at', 'desc')->get();
        $requests = ModelsRequest::select('user_id', 'quantity', 'item_id')->where('status', 0)->where('type', 2)->where('so_id', $sales_order->id)->orderBy('created_at', 'DESC')->get();

        $data = compact('sales_order', 'so_items', 'requests');
        return view('sales_orders.add_items', $data);
    }

    public function SaveItems(SalesOrder $sales_order, Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.quantity' => 'required|min:1',
        ]);

        $parts = explode('-', $sales_order->name);
        $counter = 0;

        foreach ($request->items as $id => $quantity) {
            $item = Item::findOrFail($id);

            if (($item->quantity - $quantity['quantity']) < 0) {
                return redirect()->back()->with('error', 'Item not available...');
            }

            ModelsRequest::create([
                'user_id' => auth()->user()->id,
                'item_id' => $item->id,
                'so_id' => $sales_order->id,
                'quantity' => $quantity['quantity'],
                'type' => 2,
                'status' => 0,
                'created_at' => Carbon::now()->addSeconds($counter),
            ]);

            $counter++;
        }

        return redirect()->back()->with('info', 'Request sent!');
    }

    public function search(Request $request)
    {
        $sales_order = SalesOrder::findOrFail($request->so_id);
        $parts = explode('-', $sales_order->name);

        $query = $request->search;

        $result = Item::select('id', 'itemcode', 'quantity')->where('itemcode', $query)->get()->firstOrFail();

        if ($result == null) {
            abort(400, 'Bad Request');
        } else {
            return response()->json($result);
        }
    }

    public function live_search(Request $request)
    {
        $sales_order = SalesOrder::findOrFail($request->so_id);
        $parts = explode('-', $sales_order->name);

        $query = $request->live_search;

        if ($query != null) {
            $items = Item::select('id', 'itemcode', 'quantity')->where('itemcode', 'LIKE', "%{$query}%")->get();
        } else {
            $items = Item::select('id', 'itemcode', 'quantity')->get();
        }

        if ($items == null) {
            abort(400, 'Bad Request');
        } else {
            return response()->json($items);
        }
    }

    public function destroy(SalesOrder $sales_order)
    {
        $text = ucwords(auth()->user()->name) . " deleted so : " . $sales_order->name . ", datetime :   " . now();

        Log::create(['text' => $text]);
        $sales_order->delete();

        return redirect()->back()->with('error', 'Sales Order deleted successfully!');
    }

    public function new_invoice(SalesOrder $sales_order)
    {
        $clients = Client::select('id', 'name', 'tax_id')->get();
        $items = Item::select('id', 'itemcode', 'unit_cost', 'unit_price', 'type')->get();
        $taxes = Tax::select('id', 'name', 'rate')->get();
        $data = compact('clients', 'items', 'taxes', 'sales_order');

        return view('invoices.new', $data);
    }
}
