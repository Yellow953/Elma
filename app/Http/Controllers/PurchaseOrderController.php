<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Log;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\Shipment;
use App\Models\Supplier;
use App\Models\Tax;
use Illuminate\Http\Request;

class PurchaseOrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:purchase_orders.read')->only('index');
        $this->middleware('permission:purchase_orders.create')->only(['new', 'create']);
        $this->middleware('permission:purchase_orders.update')->only(['edit', 'update']);
        $this->middleware('permission:purchase_orders.delete')->only('destroy');
        $this->middleware('permission:purchase_orders.export')->only('export');
    }

    public function index()
    {
        $purchase_orders = PurchaseOrder::select('id', 'po_number', 'supplier_id', 'shipment_id', 'order_date', 'due_date', 'status')->filter()->orderBy('id', 'desc')->paginate(25);
        $suppliers = Supplier::select('id', 'name')->get();
        $shipments = Shipment::select('id', 'shipment_number')->get();

        $data = compact('purchase_orders', 'shipments', 'suppliers');
        return view('purchase_orders.index', $data);
    }

    public function new()
    {
        $suppliers = Supplier::select('id', 'name')->get();
        $shipments = Shipment::select('id', 'shipment_number')->get();
        $items = Item::select('id', 'name')->where('type', 'expense')->get();

        $data = compact('shipments', 'suppliers', 'items');
        return view('purchase_orders.new', $data);
    }

    public function create(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required',
            'shipment_id' => 'required',
            'order_date' => 'required|date',
            'due_date' => 'nullable|date',
            'status' => 'required',
            'notes' => 'nullable',
            'items' => 'array|required'
        ]);

        $purchase_order = PurchaseOrder::create([
            'po_number' => PurchaseOrder::generate_po_number(),
            'supplier_id' => $request->supplier_id,
            'shipment_id' => $request->shipment_id,
            'status' => $request->status,
            'order_date' => $request->order_date,
            'due_date' => $request->due_date,
            'notes' => $request->notes,
        ]);

        foreach ($request['items'] as $item) {
            PurchaseOrderItem::create([
                'purchase_order_id' => $purchase_order->id,
                'item_id' => $item['item_id'],
                'supplier_id' => $request->supplier_id,
                'type' => 'expense',
                'unit_price' => $item['price'],
                'quantity' => $item['quantity'] ?? 1,
                'total_price' => $item['price'] * ($item['quantity'] ?? 1)
            ]);
        }

        $text = ucwords(auth()->user()->name) . " created Purchase Order " . $purchase_order->po_number . ", datetime :   " . now();
        Log::create(['text' => $text]);

        return redirect()->route('purchase_orders')->with('success', 'Purchase Order created successfully!');
    }

    public function edit(PurchaseOrder $purchase_order)
    {
        $suppliers = Supplier::select('id', 'name')->get();
        $items = Item::select('id', 'name')->where('type', 'expense')->get();

        $data = compact('purchase_order', 'suppliers', 'items');
        return view('purchase_orders.edit', $data);
    }

    public function update(PurchaseOrder $purchase_order, Request $request)
    {
        $request->validate([
            'order_date' => 'required|date',
            'due_date' => 'nullable|date',
            'status' => 'required',
            'notes' => 'nullable',
            'items' => 'array|required'
        ]);

        $purchase_order->update([
            'status' => $request->status,
            'order_date' => $request->order_date,
            'due_date' => $request->due_date,
            'notes' => $request->notes,
        ]);

        if (isset($request['items'])) {
            foreach ($request['items'] as $item) {
                PurchaseOrderItem::create([
                    'purchase_order_id' => $purchase_order->id,
                    'item_id' => $item['item_id'],
                    'supplier_id' => $request->supplier_id,
                    'type' => 'expense',
                    'unit_price' => $item['price'],
                    'quantity' => $item['quantity'] ?? 1,
                    'total_price' => $item['price'] * ($item['quantity'] ?? 1)
                ]);
            }
        }

        $text = ucwords(auth()->user()->name) . ' updated Purchase Order ' . $purchase_order->name . ", datetime :   " . now();
        log::create(['text' => $text]);

        return redirect()->route('purchase_order')->with('warning', 'Purchase Order updated successfully!');
    }

    public function show(PurchaseOrder $purchase_order)
    {
        $shipment = $purchase_order->shipment;

        $data = compact('purchase_order', 'shipment');
        return view('purchase_orders.show', $data);
    }

    public function search(Request $request)
    {
        $purchase_order = PurchaseOrder::findOrFail($request->purchase_order_id);
        $parts = explode('-', $purchase_order->name);

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
        $purchase_order = PurchaseOrder::findOrFail($request->purchase_order_id);
        $parts = explode('-', $purchase_order->name);

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

    public function destroy(PurchaseOrder $purchase_order)
    {
        if ($purchase_order->can_delete()) {
            $text = ucwords(auth()->user()->name) . " deleted purchase_order : " . $purchase_order->name . ", datetime :   " . now();

            foreach ($purchase_order->items as $item) {
                $item->delete();
            }

            Log::create(['text' => $text]);
            $purchase_order->delete();

            return redirect()->back()->with('error', 'PurchaseOrder deleted successfully!');
        } else {
            return redirect()->back()->with('error', 'Unothorized Access...');
        }
    }

    public function new_receipt(PurchaseOrder $purchase_order)
    {
        $items = Item::select('id', 'name', 'unit_price', 'unit', 'type')->where('type', 'expense')->get();
        $taxes = Tax::select('id', 'name', 'rate')->get();
        $suppliers = Supplier::select('id', 'name')->get();
        $data = compact('suppliers', 'items', 'taxes', 'purchase_order');

        return view('receipts.new', $data);
    }

    public function item_destroy(PurchaseOrderItem $purchase_order_item)
    {
        $purchase_order_item->delete();

        return redirect()->back()->with('success', 'Purchase Order Item deleted successfully!');
    }
}
