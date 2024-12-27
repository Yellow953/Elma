<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Log;
use App\Models\PO;
use App\Models\POItem;
use App\Models\Request as ModelsRequest;
use App\Models\Supplier;
use App\Models\Tax;
use App\Models\Warehouse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class POController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('setup');
        $this->middleware('agreed');
        $this->middleware('accountant')->only('new_receipt');
        $this->middleware('admin')->only('destroy');
    }

    public function index()
    {
        if (auth()->user()->role == 'admin') {
            $pos = PO::select('id', 'name', 'supplier_id', 'date')->filter()->orderBy('id', 'desc')->paginate(25);
        } else {
            $search = auth()->user()->location->code . '-PO';
            $pos = PO::select('id', 'name', 'supplier_id', 'date')->where('name', 'LIKE', "%{$search}%")->filter()->orderBy('id', 'desc')->paginate(25);
        }
        $suppliers = Supplier::select('id', 'name')->get();

        $data = compact('pos', 'suppliers');
        return view('pos.index', $data);
    }

    public function new()
    {
        $suppliers = Supplier::select('id', 'name')->get();
        return view('pos.new', compact('suppliers'));
    }

    public function create(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|numeric',
        ]);

        $po = PO::create([
            'name' => PO::generate_name(),
            'supplier_id' => $request->supplier_id,
            'description' => $request->description,
            'date' => $request->date ?? Carbon::now(),
        ]);

        $text = ucwords(auth()->user()->name) . " created " . $po->name . ", datetime :   " . now();
        Log::create(['text' => $text]);

        return redirect()->route('po')->with('success', 'PO created successfully!');
    }

    public function edit(PO $po)
    {
        $parts = explode('-', $po->name);
        $warehouse = Warehouse::where("code", $parts[0])->firstOrFail();
        $search = request()->query('search');

        if (auth()->user()->role != 'admin' && auth()->user()->location_id != $warehouse->id) {
            return redirect()->back()->with('error', 'You are not allowed to access this page...');
        }

        if ($search) {
            $item = Item::where('warehouse_id', $warehouse->id)->where('itemcode', 'LIKE', "%{$search}%")->firstOrFail();
            if ($item != null) {
                $poItems = POItem::select('id', 'item_id', 'quantity')->where('po_id', $po->id)->where('item_id', $item->id)->paginate(50);
            } else {
                $poItems = new Collection();
            }
        } else {
            $poItems = POItem::select('id', 'item_id', 'quantity')->where('po_id', $po->id)->orderBy('created_at', 'asc')->paginate(50);
        }
        $suppliers = Supplier::select('id', 'name')->get();

        $data = compact('po', 'poItems', 'suppliers');
        return view('pos.edit', $data);
    }

    public function update(PO $po, Request $request)
    {
        $po->update([
            'supplier_id' => $request->supplier_id,
            'description' => $request->description,
            'date' => $request->date,
        ]);

        $text = ucwords(auth()->user()->name) . ' updated ' . $po->name . ", datetime :   " . now();
        log::create(['text' => $text]);

        return redirect()->route('po')->with('warning', 'PO updated successfully!');
    }

    public function show(PO $po)
    {
        return view('pos.show', compact('po'));
    }

    public function print(PO $po)
    {
        return view('pos.show', compact('po'));
    }

    public function activity(PO $po)
    {
        $search_term1 = " " . trim($po->name) . ",";
        $search_term2 = " " . trim($po->name) . " ";
        $logs = Log::select('text')->where('text', 'LIKE', "%{$search_term1}%")->orWhere('text', 'LIKE', "%{$search_term2}%")->orderBy('id', 'desc')->get();

        $data = compact('po', 'logs');
        return view('pos.activity', $data);
    }

    public function Return(POItem $poItem)
    {
        $item = Item::findOrFail($poItem->item_id);
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        ModelsRequest::create([
            'user_id' => auth()->user()->id,
            'item_id' => $item->id,
            'po_id' => $poItem->id,
            'quantity' => $poItem->quantity,
            'type' => 11,
            'status' => 0,
            'warehouse_id' => $item->warehouse_id,
        ]);

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
        return redirect()->back()->with('info', 'Request sent!');
    }

    public function return_all($id)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        $poItems = POItem::where('po_id', $id)->get();
        foreach ($poItems as $poItem) {
            $item = Item::findOrFail($poItem->item_id);

            ModelsRequest::create([
                'user_id' => auth()->user()->id,
                'item_id' => $item->id,
                'po_id' => $poItem->id,
                'quantity' => $poItem->quantity,
                'type' => 11,
                'status' => 0,
                'warehouse_id' => $item->warehouse_id,
            ]);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
        return redirect()->back()->with('info', 'Request sent!');
    }

    public function AddItems(PO $po)
    {
        $parts = explode('-', $po->name);
        $warehouse = Warehouse::where("code", $parts[0])->firstOrFail();

        if (auth()->user()->role != 'admin' && auth()->user()->location_id != $warehouse->id) {
            return redirect()->back()->with('error', 'You are not allowed to access this page...');
        }

        $po_items = POItem::select('item_id', 'quantity')->where('po_id', $po->id)->orderBy('created_at', 'desc')->get();
        $requests = ModelsRequest::select('user_id', 'quantity', 'item_id')->where('status', 0)->where('type', 9)->where('po_id', $po->id)->orderBy('created_at', 'DESC')->get();

        $data = compact('po', 'po_items', 'requests');
        return view('pos.add_items', $data);
    }

    public function SaveItems(PO $po, Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.quantity' => 'required|min:1',
        ]);

        $parts = explode('-', $po->name);
        $warehouse = Warehouse::where("code", $parts[0])->firstOrFail();
        $counter = 0;

        foreach ($request->items as $id => $quantity) {
            $item = Item::findOrFail($id);

            ModelsRequest::create([
                'user_id' => auth()->user()->id,
                'item_id' => $item->id,
                'po_id' => $po->id,
                'quantity' => $quantity['quantity'],
                'warehouse_id' => $warehouse->id,
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
        $po = PO::findOrFail($request->po_id);
        $parts = explode('-', $po->name);
        $warehouse = Warehouse::where("code", $parts[0])->firstOrFail();

        $query = $request->search;

        $result = Item::select('id', 'itemcode', 'quantity')->where('warehouse_id', $warehouse->id)->where('itemcode', $query)->get()->firstOrFail();

        if ($result == null) {
            abort(400, 'Bad Request');
        } else {
            return response()->json($result);
        }
    }

    public function live_search(Request $request)
    {
        $po = PO::findOrFail($request->po_id);
        $parts = explode('-', $po->name);
        $warehouse = Warehouse::where("code", $parts[0])->firstOrFail();

        $query = $request->live_search;

        if ($query != null) {
            $items = Item::select('id', 'itemcode', 'quantity')->where('warehouse_id', $warehouse->id)->where('itemcode', 'LIKE', "%{$query}%")->get();
        } else {
            $items = Item::select('id', 'itemcode', 'quantity')->where('warehouse_id', $warehouse->id)->get();
        }

        if ($items == null) {
            abort(400, 'Bad Request');
        } else {
            return response()->json($items);
        }
    }

    public function quantities(PO $po)
    {
        $po_items = POItem::select('item_id', 'quantity')->where('po_id', $po->id)->get();

        $data = compact('po', 'po_items');
        return view('pos.quantities', $data);
    }

    public function destroy(PO $po)
    {
        if ($po->can_delete()) {
            $text = ucwords(auth()->user()->name) . " deleted po : " . $po->name . ", datetime :   " . now();

            Log::create(['text' => $text]);
            $po->delete();

            return redirect()->back()->with('error', 'PO deleted successfully!');
        } else {
            return redirect()->back()->with('error', 'Unothorized Access...');
        }
    }

    public function new_receipt(PO $po)
    {
        $suppliers = Supplier::select('id', 'name', 'tax_id')->get();
        $items = Item::select('id', 'itemcode', 'warehouse_id', 'type')->get();
        $taxes = Tax::select('id', 'name', 'rate')->get();
        $data = compact('suppliers', 'items', 'taxes', 'po');

        return view('receipts.new', $data);
    }
}
