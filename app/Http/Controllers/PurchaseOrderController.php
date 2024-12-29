<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Log;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\Supplier;
use App\Models\Tax;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

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
        $purchase_orders = PurchaseOrder::select('id', 'name', 'date')->filter()->orderBy('id', 'desc')->paginate(25);

        $data = compact('purchase_orders');
        return view('purchase_orders.index', $data);
    }

    public function new()
    {
        return view('purchase_orders.new', compact('suppliers'));
    }

    public function create(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
        ]);

        $purchase_order = PurchaseOrder::create([
            'name' => PurchaseOrder::generate_name(),
            'description' => $request->description,
            'date' => $request->date ?? Carbon::now(),
        ]);

        $text = ucwords(auth()->user()->name) . " created " . $purchase_order->name . ", datetime :   " . now();
        Log::create(['text' => $text]);

        return redirect()->route('purchase_order')->with('success', 'PurchaseOrder created successfully!');
    }

    public function edit(PurchaseOrder $purchase_order)
    {
        $parts = explode('-', $purchase_order->name);
        $search = request()->query('search');

        if ($search) {
            $item = Item::where('itemcode', 'LIKE', "%{$search}%")->firstOrFail();
            if ($item != null) {
                $purchase_order_items = PurchaseOrderItem::select('id', 'item_id', 'quantity')->where('po_id', $purchase_order->id)->where('item_id', $item->id)->paginate(50);
            } else {
                $purchase_order_items = new Collection();
            }
        } else {
            $purchase_order_items = PurchaseOrderItem::select('id', 'item_id', 'quantity')->where('po_id', $purchase_order->id)->orderBy('created_at', 'asc')->paginate(50);
        }
        $suppliers = Supplier::select('id', 'name')->get();

        $data = compact('purchase_order', 'purchase_order_items', 'suppliers');
        return view('purchase_orders.edit', $data);
    }

    public function update(PurchaseOrder $purchase_order, Request $request)
    {
        $purchase_order->update([
            'supplier_id' => $request->supplier_id,
            'description' => $request->description,
            'date' => $request->date,
        ]);

        $text = ucwords(auth()->user()->name) . ' updated ' . $purchase_order->name . ", datetime :   " . now();
        log::create(['text' => $text]);

        return redirect()->route('purchase_order')->with('warning', 'PurchaseOrder updated successfully!');
    }

    public function show(PurchaseOrder $purchase_order)
    {
        return view('purchase_orders.show', compact('purchase_order'));
    }

    public function print(PurchaseOrder $purchase_order)
    {
        return view('purchase_orders.show', compact('purchase_order'));
    }

    public function activity(PurchaseOrder $purchase_order)
    {
        $search_term1 = " " . trim($purchase_order->name) . ",";
        $search_term2 = " " . trim($purchase_order->name) . " ";
        $logs = Log::select('text')->where('text', 'LIKE', "%{$search_term1}%")->orWhere('text', 'LIKE', "%{$search_term2}%")->orderBy('id', 'desc')->get();

        $data = compact('purchase_order', 'logs');
        return view('purchase_orders.activity', $data);
    }

    public function Return(PurchaseOrderItem $purchase_order_item)
    {
        $item = Item::findOrFail($purchase_order_item->item_id);
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        ModelsRequest::create([
            'user_id' => auth()->user()->id,
            'item_id' => $item->id,
            'po_id' => $purchase_order_item->id,
            'quantity' => $purchase_order_item->quantity,
            'type' => 11,
            'status' => 0,
        ]);

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
        return redirect()->back()->with('info', 'Request sent!');
    }

    public function return_all($id)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        $purchase_order_items = PurchaseOrderItem::where('po_id', $id)->get();
        foreach ($purchase_order_items as $purchase_order_item) {
            $item = Item::findOrFail($purchase_order_item->item_id);

            ModelsRequest::create([
                'user_id' => auth()->user()->id,
                'item_id' => $item->id,
                'po_id' => $purchase_order_item->id,
                'quantity' => $purchase_order_item->quantity,
                'type' => 11,
                'status' => 0,
            ]);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
        return redirect()->back()->with('info', 'Request sent!');
    }

    public function AddItems(PurchaseOrder $purchase_order)
    {
        $parts = explode('-', $purchase_order->name);

        $purchase_order_items = PurchaseOrderItem::select('item_id', 'quantity')->where('purchase_order_id', $purchase_order->id)->orderBy('created_at', 'desc')->get();

        $data = compact('purchase_order', 'purchase_order_items');
        return view('purchase_orders.add_items', $data);
    }

    public function SaveItems(PurchaseOrder $purchase_order, Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.quantity' => 'required|min:1',
        ]);

        $parts = explode('-', $purchase_order->name);
        $counter = 0;

        foreach ($request->items as $id => $quantity) {
            $item = Item::findOrFail($id);

            ModelsRequest::create([
                'user_id' => auth()->user()->id,
                'item_id' => $item->id,
                'po_id' => $purchase_order->id,
                'quantity' => $quantity['quantity'],
                'type' => 9,
                'status' => 0,
                'created_at' => Carbon::now()->addSeconds($counter),
            ]);

            $counter++;
        }

        return redirect()->back()->with('info', 'Request sent!');
    }

    public function search(Request $request)
    {
        $purchase_order = PurchaseOrder::findOrFail($request->po_id);
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
        $purchase_order = PurchaseOrder::findOrFail($request->po_id);
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

            Log::create(['text' => $text]);
            $purchase_order->delete();

            return redirect()->back()->with('error', 'PurchaseOrder deleted successfully!');
        } else {
            return redirect()->back()->with('error', 'Unothorized Access...');
        }
    }

    public function new_receipt(PurchaseOrder $purchase_order)
    {
        $suppliers = Supplier::select('id', 'name', 'tax_id')->get();
        $items = Item::select('id', 'itemcode', 'type')->get();
        $taxes = Tax::select('id', 'name', 'rate')->get();
        $data = compact('suppliers', 'items', 'taxes', 'purchase_order');

        return view('receipts.new', $data);
    }
}
