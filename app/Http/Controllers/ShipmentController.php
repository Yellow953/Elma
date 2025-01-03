<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Item;
use App\Models\Log;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\SalesOrder;
use App\Models\SalesOrderItem;
use App\Models\Shipment;
use App\Models\ShipmentItem;
use App\Models\Supplier;
use Illuminate\Http\Request;

class ShipmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:shipments.read')->only(['index', 'show']);
        $this->middleware('permission:shipments.create')->only(['new', 'create']);
        $this->middleware('permission:shipments.update')->only(['edit', 'update']);
        $this->middleware('permission:shipments.delete')->only('destroy');
        $this->middleware('permission:shipments.export')->only('export');
    }

    public function index()
    {
        $shipments = Shipment::select('id', 'shipment_number', 'mode', 'departure', 'arrival', 'commodity', 'status', 'client_id', 'shipping_date', 'delivery_date')->filter()->orderBy('id', 'desc')->paginate(25);
        $clients = Client::select('id', 'name')->get();

        $data = compact('shipments', 'clients');
        return view('shipments.index', $data);
    }

    public function new()
    {
        $clients = Client::select('id', 'name')->get();
        $items = Item::select('id', 'name', 'type', 'unit_price')->get();
        $suppliers = Supplier::select('id', 'name')->get();

        $data = compact('clients', 'items', 'suppliers');
        return view('shipments.new', $data);
    }

    public function create(Request $request)
    {
        $request->validate([
            'shipment_number' => 'required|string|max:255',
            'mode' => 'required',
            'departure' => 'required',
            'arrival' => 'required',
            'commodity' => 'required',
            'status' => 'required',
            'client_id' => 'required',
            'shipping_date' => 'required|date',
            'delivery_date' => 'nullable|date',
            'notes' => 'nullable',
            'items' => 'array|required'
        ]);

        $shipment = Shipment::create([
            'shipment_number' => $request->shipment_number,
            'mode' => $request->mode,
            'departure' => $request->departure,
            'arrival' => $request->arrival,
            'commodity' => $request->commodity,
            'status' => $request->status,
            'client_id' => $request->client_id,
            'shipping_date' => $request->shipping_date,
            'delivery_date' => $request->delivery_date,
            'notes' => $request->notes,
        ]);

        $salesOrderItems = [];
        $groupedPurchaseOrderItems = []; // Group by supplier_id

        foreach ($request['items'] as $item) {
            $shipmentItem = ShipmentItem::create([
                'shipment_id' => $shipment->id,
                'item_id' => $item['item_id'],
                'supplier_id' => $item['supplier_id'] ?? null,
                'type' => (isset($item['supplier_id']) ? 'expense' : 'item'),
                'unit_price' => $item['price'],
                'quantity' => $item['quantity'] ?? 1,
                'total_price' => $item['price'] * ($item['quantity'] ?? 1)
            ]);

            if ($shipmentItem->type === 'item') {
                $salesOrderItems[] = [
                    'type' => 'item',
                    'item_id' => $shipmentItem->item_id,
                    'quantity' => $shipmentItem->quantity,
                    'unit_price' => $shipmentItem->unit_price,
                    'total_price' => $shipmentItem->total_price,
                ];
            } elseif ($shipmentItem->type === 'expense' && $shipmentItem->supplier_id) {
                $groupedPurchaseOrderItems[$shipmentItem->supplier_id][] = [
                    'type' => 'expense',
                    'item_id' => $shipmentItem->item_id,
                    'quantity' => $shipmentItem->quantity,
                    'unit_price' => $shipmentItem->unit_price,
                    'total_price' => $shipmentItem->total_price,
                ];
            }
        }

        // Create Sales Order
        if (!empty($salesOrderItems)) {
            $salesOrder = SalesOrder::create([
                'so_number' => SalesOrder::generate_so_number(),
                'client_id' => $request->client_id,
                'order_date' => $request->shipping_date,
                'due_date' => $request->delivery_date,
                'status' => 'new',
                'shipment_id' => $shipment->id,
                'notes' => $request->notes,
            ]);

            foreach ($salesOrderItems as $item) {
                $item['sales_order_id'] = $salesOrder->id;
                SalesOrderItem::create($item);
            }
        }

        // Create Purchase Orders for each supplier
        foreach ($groupedPurchaseOrderItems as $supplierId => $items) {
            $purchaseOrder = PurchaseOrder::create([
                'po_number' => PurchaseOrder::generate_po_number(),
                'supplier_id' => $supplierId,
                'order_date' => $request->shipping_date,
                'due_date' => $request->delivery_date,
                'status' => 'new',
                'shipment_id' => $shipment->id,
                'notes' => $request->notes,
            ]);

            foreach ($items as $item) {
                $item['purchase_order_id'] = $purchaseOrder->id;
                PurchaseOrderItem::create($item);
            }
        }

        // Log the creation
        $text = ucwords(auth()->user()->name) . " created new Shipment: " . $shipment->shipment_number . ", datetime: " . now();
        Log::create(['text' => $text]);

        return redirect()->route('shipments')->with('success', 'Shipment created successfully!');
    }


    public function edit(Shipment $shipment)
    {
        $clients = Client::select('id', 'name')->get();
        $items = Item::select('id', 'name', 'type', 'unit_price')->get();
        $suppliers = Supplier::select('id', 'name')->get();

        $data = compact('shipment', 'clients', 'items', 'suppliers');
        return view('shipments.edit', $data);
    }

    public function update(Shipment $shipment, Request $request)
    {
        $request->validate([
            'shipment_number' => 'required|string|max:255',
            'mode' => 'required',
            'departure' => 'required',
            'arrival' => 'required',
            'commodity'  => 'required',
            'status' => 'required',
            'client_id' => 'required',
            'shipping_date' => 'required|date',
            'delivery_date' => 'nullable|date',
            'notes' => 'nullable'
        ]);

        $text = ucwords(auth()->user()->name) . ' updated Shipment ' . $shipment->name . ", datetime :   " . now();

        $shipment->update([
            'shipment_number' => $request->shipment_number,
            'mode' => $request->mode,
            'departure' => $request->departure,
            'arrival' => $request->arrival,
            'commodity' => $request->commodity,
            'status' => $request->status,
            'client_id' => $request->client_id,
            'shipping_date' => $request->shipping_date,
            'delivery_date' => $request->delivery_date,
            'notes' => $request->notes,
        ]);

        if (isset($request['items'])) {
            foreach ($request['items'] as $item) {
                ShipmentItem::create([
                    'shipment_id' => $shipment->id,
                    'item_id' => $item['item_id'],
                    'supplier_id' => $item['supplier_id'] ?? null,
                    'type' => (isset($item['supplier_id']) ? 'expense' : 'item'),
                    'unit_price' => $item['price'],
                    'quantity' => $item['quantity'] ?? 1,
                    'total_price' => $item['price'] * ($item['quantity'] ?? 1)
                ]);
            }
        }

        Log::create(['text' => $text]);

        return redirect()->route('shipments')->with('warning', 'Shipment updated successfully!');
    }

    public function destroy(Shipment $shipment)
    {
        $text = ucwords(auth()->user()->name) . " deleted Shipment : " . $shipment->name . ", datetime :   " . now();

        foreach ($shipment->items as $item) {
            $item->delete();
        }

        Log::create(['text' => $text]);
        $shipment->delete();

        return redirect()->back()->with('error', 'Shipment deleted successfully!');
    }

    public function item_destroy(ShipmentItem $shipment_item)
    {
        $shipment_item->delete();

        return redirect()->back()->with('success', 'Shipment Item deleted successfully!');
    }

    public function show(Shipment $shipment)
    {
        return view('shipments.show', compact('shipment'));
    }
}
