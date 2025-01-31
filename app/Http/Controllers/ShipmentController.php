<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
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
    }

    public function index()
    {
        $shipments = Shipment::select('id', 'shipment_number', 'mode', 'departure', 'arrival', 'commodity', 'due_from_id', 'shipper', 'loading_date', 'vessel_name', 'vessel_date', 'booking_number', 'container_number', 'carrier_name', 'consignee_name', 'consignee_country')->filter()->orderBy('id', 'desc')->paginate(25);
        $clients = Client::select('id', 'name')->get();
        $modes = Helper::get_shipping_modes();
        $ports = Helper::get_shipping_ports();

        $data = compact('shipments', 'clients', 'modes', 'ports');
        return view('shipments.index', $data);
    }

    public function new()
    {
        $clients = Client::select('id', 'name')->get();
        $items = Item::select('id', 'name', 'type', 'unit_price')->get();
        $suppliers = Supplier::select('id', 'name')->get();
        $modes = Helper::get_shipping_modes();
        $ports = Helper::get_shipping_ports();
        $countries = Helper::get_countries();

        $data = compact('clients', 'items', 'suppliers', 'modes', 'ports', 'countries');
        return view('shipments.new', $data);
    }

    public function create(Request $request)
    {
        $request->validate([
            'mode' => 'required',
            'departure' => 'required',
            'arrival' => 'required',
            'commodity' => 'required',
            'due_from_id' => 'required',
            'shipper' => 'required|string|max:255',
            'loading_date' => 'required|date',
            'vessel_name' => 'required|string|max:255',
            'vessel_date' => 'required|date',
            'booking_number' => 'required|string|max:255',
            'container_number' => 'required|string|max:255',
            'carrier_name' => 'required|string|max:255',
            'consignee_name' => 'required|string|max:255',
            'consignee_country' => 'required',
            'notes' => 'nullable',
            'items' => 'array|required'
        ]);

        $shipment = Shipment::create([
            'shipment_number' => Shipment::generate_shipment_number(),
            'mode' => $request->mode,
            'departure' => $request->departure,
            'arrival' => $request->arrival,
            'commodity' => $request->commodity,
            'due_from_id' => $request->due_from_id,
            'shipper' => $request->shipper,
            'loading_date' => $request->loading_date,
            'vessel_name' => $request->vessel_name,
            'vessel_date' => $request->vessel_date,
            'booking_number' => $request->booking_number,
            'container_number' => $request->container_number,
            'carrier_name' => $request->carrier_name,
            'consignee_name' => $request->consignee_name,
            'consignee_country' => $request->consignee_country,
            'notes' => $request->notes,
        ]);

        $salesOrderItems = [];
        $groupedPurchaseOrderItems = [];

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

        if (!empty($salesOrderItems)) {
            $salesOrder = SalesOrder::create([
                'so_number' => SalesOrder::generate_so_number(),
                'client_id' => $request->due_from_id,
                'order_date' => $request->loading_date,
                'due_date' => $request->loading_date,
                'status' => 'new',
                'shipment_id' => $shipment->id,
                'notes' => $request->notes,
            ]);

            foreach ($salesOrderItems as $item) {
                $item['sales_order_id'] = $salesOrder->id;
                SalesOrderItem::create($item);
            }
        }

        foreach ($groupedPurchaseOrderItems as $supplierId => $items) {
            $purchaseOrder = PurchaseOrder::create([
                'po_number' => PurchaseOrder::generate_po_number(),
                'supplier_id' => $supplierId,
                'order_date' => $request->loading_date,
                'due_date' => $request->loading_date,
                'status' => 'new',
                'shipment_id' => $shipment->id,
                'notes' => $request->notes,
            ]);

            foreach ($items as $item) {
                $item['purchase_order_id'] = $purchaseOrder->id;
                PurchaseOrderItem::create($item);
            }
        }

        $text = ucwords(auth()->user()->name) . " created new Shipment: " . $shipment->shipment_number . ", datetime: " . now();
        Log::create(['text' => $text]);

        return redirect()->route('shipments')->with('success', 'Shipment created successfully!');
    }


    public function edit(Shipment $shipment)
    {
        $clients = Client::select('id', 'name')->get();
        $items = Item::select('id', 'name', 'type', 'unit_price')->get();
        $suppliers = Supplier::select('id', 'name')->get();
        $modes = Helper::get_shipping_modes();
        $ports = Helper::get_shipping_ports();
        $countries = Helper::get_countries();

        $data = compact('shipment', 'clients', 'items', 'suppliers', 'modes', 'ports', 'countries');
        return view('shipments.edit', $data);
    }

    public function update(Shipment $shipment, Request $request)
    {
        $request->validate([
            'shipment_number' => 'required|string|max:255',
            'mode' => 'required',
            'departure' => 'required',
            'arrival' => 'required',
            'commodity' => 'required',
            'due_from_id' => 'required',
            'shipper' => 'required|string|max:255',
            'loading_date' => 'required|date',
            'vessel_name' => 'required|string|max:255',
            'vessel_date' => 'required|date',
            'booking_number' => 'required|string|max:255',
            'container_number' => 'required|string|max:255',
            'carrier_name' => 'required|string|max:255',
            'consignee_name' => 'required|string|max:255',
            'consignee_country' => 'required',
            'notes' => 'nullable',
            'items' => 'nullable|array'
        ]);

        $text = ucwords(auth()->user()->name) . ' updated Shipment ' . $shipment->name . ", datetime :   " . now();

        $shipment->update([
            'shipment_number' => $request->shipment_number,
            'mode' => $request->mode,
            'departure' => $request->departure,
            'arrival' => $request->arrival,
            'commodity' => $request->commodity,
            'due_from_id' => $request->due_from_id,
            'shipper' => $request->shipper,
            'loading_date' => $request->loading_date,
            'vessel_name' => $request->vessel_name,
            'vessel_date' => $request->vessel_date,
            'booking_number' => $request->booking_number,
            'conta_nuinermber' => $request->conta_number,
            'carrier_name' => $request->carrier_name,
            'consignee_name' => $request->consignee_name,
            'consignee_country' => $request->consignee_country,
            'notes' => $request->notes,
        ]);

        if (isset($request['items'])) {
            $salesOrderItems = [];
            $groupedPurchaseOrderItems = [];

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

            if (!empty($salesOrderItems)) {
                $salesOrder = $shipment->sales_order;

                foreach ($salesOrderItems as $item) {
                    $item['sales_order_id'] = $salesOrder->id;
                    SalesOrderItem::create($item);
                }
            }

            foreach ($groupedPurchaseOrderItems as $supplierId => $items) {
                $purchaseOrder = PurchaseOrder::create([
                    'po_number' => PurchaseOrder::generate_po_number(),
                    'supplier_id' => $supplierId,
                    'order_date' => $request->loading_date,
                    'due_date' => $request->loading_date,
                    'status' => 'new',
                    'shipment_id' => $shipment->id,
                    'notes' => $request->notes,
                ]);

                foreach ($items as $item) {
                    $item['purchase_order_id'] = $purchaseOrder->id;
                    PurchaseOrderItem::create($item);
                }
            }
        }

        Log::create(['text' => $text]);

        return redirect()->route('shipments')->with('warning', 'Shipment updated successfully!');
    }

    public function destroy(Shipment $shipment)
    {
        if ($shipment->can_delete()) {
            $text = ucwords(auth()->user()->name) . " deleted Shipment : " . $shipment->name . ", datetime :   " . now();

            foreach ($shipment->items as $item) {
                $item->delete();
            }

            if ($shipment->sales_order) {
                foreach ($shipment->sales_order->items as $so_item) {
                    $so_item->delete();
                }
                $shipment->sales_order->delete();
            }

            if ($shipment->purchase_orders) {
                foreach ($shipment->purchase_orders as $po) {
                    foreach ($po->items as $po_item) {
                        $po_item->delete();
                    }
                    $po->delete();
                }
            }

            Log::create(['text' => $text]);
            $shipment->delete();

            return redirect()->back()->with('error', 'Shipment deleted successfully!');
        } else {
            return redirect()->back()->with('error', 'Unable to delete...');
        }
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
