<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Client;
use App\Models\SalesOrder;
use App\Models\SalesOrderItem;
use App\Models\Item;
use App\Models\Log;
use App\Models\Shipment;
use App\Models\Supplier;
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
        $sales_orders = SalesOrder::select('id', 'so_number', 'client_id', 'shipment_id', 'order_date', 'due_date', 'status')->filter()->orderBy('id', 'desc')->paginate(25);
        $clients = Client::select('id', 'name')->get();
        $shipments = Shipment::select('id', 'shipment_number')->get();

        $data = compact('sales_orders', 'clients', 'shipments');
        return view('sales_orders.index', $data);
    }

    public function new()
    {
        $clients = Client::select('id', 'name')->get();
        $shipments = Shipment::select('id', 'shipment_number')->get();
        $items = Item::select('id', 'name', 'unit_price', 'type')->get();
        $suppliers = Supplier::select('id', 'name')->get();

        $data = compact('clients', 'shipments', 'items', 'suppliers');
        return view('sales_orders.new', $data);
    }

    public function create(Request $request)
    {
        $request->validate([
            'client_id' => 'required',
            'shipment_id' => 'required',
            'order_date' => 'required|date',
            'due_date' => 'nullable|date',
            'status' => 'required',
            'notes' => 'nullable',
            'items' => 'array|required'
        ]);

        $sales_order = SalesOrder::create([
            'so_number' => SalesOrder::generate_so_number(),
            'client_id' => $request->client_id,
            'shipment_id' => $request->shipment_id,
            'status' => $request->status,
            'order_date' => $request->order_date,
            'due_date' => $request->due_date,
            'notes' => $request->notes,
        ]);

        foreach ($request['items'] as $item) {
            $sales_order_item = SalesOrderItem::create([
                'sales_order_id' => $sales_order->id,
                'item_id' => $item['item_id'],
                'supplier_id' => $item['supplier_id'] ?? null,
                'type' => (isset($item['supplier_id']) ? 'expense' : 'item'),
                'unit_price' => $item['price'],
                'quantity' => $item['quantity'] ?? 1,
                'total_price' => $item['price'] * ($item['quantity'] ?? 1)
            ]);
        }

        $text = ucwords(auth()->user()->name) . " created Sales Order " . $sales_order->name . ", datetime :   " . now();
        Log::create(['text' => $text]);

        return redirect()->route('sales_orders')->with('success', 'Sales Order created successfully!');
    }

    public function show(SalesOrder $sales_order)
    {
        return view('sales_orders.show', compact('sales_order'));
    }

    public function edit(SalesOrder $sales_order)
    {
        $clients = Client::select('id', 'name')->get();
        $shipments = Shipment::select('id', 'shipment_number')->get();
        $items = Item::select('id', 'name', 'unit_price', 'type')->get();
        $suppliers = Supplier::select('id', 'name')->get();

        $data = compact('sales_order', 'clients', 'shipments', 'items', 'suppliers');
        return view('sales_orders.edit', $data);
    }

    public function update(SalesOrder $sales_order, Request $request)
    {
        $request->validate([
            'client_id' => 'required',
            'shipment_id' => 'required',
            'order_date' => 'required|date',
            'due_date' => 'nullable|date',
            'status' => 'required',
            'notes' => 'nullable',
            'items' => 'array|required'
        ]);

        $sales_order->update([
            'client_id' => $request->client_id,
            'shipment_id' => $request->shipment_id,
            'status' => $request->status,
            'order_date' => $request->order_date,
            'due_date' => $request->due_date,
            'notes' => $request->notes,
        ]);

        if (isset($request['items'])) {
            foreach ($request['items'] as $item) {
                SalesOrderItem::create([
                    'sales_order_id' => $sales_order->id,
                    'item_id' => $item['item_id'],
                    'supplier_id' => $item['supplier_id'] ?? null,
                    'type' => (isset($item['supplier_id']) ? 'expense' : 'item'),
                    'unit_price' => $item['price'],
                    'quantity' => $item['quantity'] ?? 1,
                    'total_price' => $item['price'] * ($item['quantity'] ?? 1)
                ]);
            }
        }

        $text = ucwords(auth()->user()->name) . ' updated Sales Order ' . $sales_order->name . ", datetime :   " . now();
        Log::create(['text' => $text]);

        return redirect()->route('sales_orders')->with('warning', 'Sales Order updated successfully!');
    }

    public function search(Request $request)
    {
        $sales_order = SalesOrder::findOrFail($request->sales_order_id);
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
        $sales_order = SalesOrder::findOrFail($request->sales_order_id);
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
        if ($sales_order->can_delete()) {
            $text = ucwords(auth()->user()->name) . " deleted so : " . $sales_order->name . ", datetime :   " . now();

            Log::create(['text' => $text]);
            $sales_order->delete();

            return redirect()->back()->with('error', 'Sales Order deleted successfully!');
        } else {
            return redirect()->back()->with('error', 'Unable to delete...');
        }
    }

    public function new_invoice(SalesOrder $sales_order)
    {
        $clients = Client::select('id', 'name', 'tax_id')->get();
        $items = Item::select('id', 'name', 'unit_price', 'unit', 'type')->get();
        $taxes = Tax::select('id', 'name', 'rate')->get();
        $suppliers = Supplier::select('id', 'name')->get();
        $currencies = Helper::get_currencies();

        $data = compact('clients', 'items', 'taxes', 'sales_order', 'suppliers', 'currencies');
        return view('invoices.new', $data);
    }

    public function item_destroy(SalesOrderItem $sales_order_item)
    {
        $sales_order_item->delete();

        return redirect()->back()->with('success', 'Sales Order Item deleted successfully!');
    }
}
