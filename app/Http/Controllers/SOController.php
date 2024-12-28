<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\SO;
use App\Models\SOItem;
use App\Models\Item;
use App\Models\Log;
use App\Models\Tax;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class SOController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:sos.read')->only('index');
        $this->middleware('permission:sos.create')->only(['new', 'create']);
        $this->middleware('permission:sos.update')->only(['edit', 'update']);
        $this->middleware('permission:sos.delete')->only('destroy');
        $this->middleware('permission:sos.export')->only('export');
    }

    public function index()
    {
        $sos = SO::select('id', 'name', 'date')->filter()->orderBy('id', 'desc')->paginate(25);

        $data = compact('sos');
        return view('sos.index', $data);
    }

    public function new()
    {
        return view('sos.new', compact('projects'));
    }

    public function create(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
        ]);

        $so = SO::create([
            'name' => SO::generate_name(),
            'description' => $request->description,
            'date' => $request->date ?? Carbon::now(),
        ]);

        $text = ucwords(auth()->user()->name) . " created " . $so->name . ", datetime :   " . now();
        Log::create(['text' => $text]);

        return redirect()->route('so')->with('success', 'SO created successfully!');
    }

    public function show(SO $so)
    {
        return view('sos.show', compact('so'));
    }

    public function display(SO $so)
    {
        return view('sos.display', compact('so'));
    }

    public function print(SO $so)
    {
        return view('sos.show', compact('so'));
    }

    public function edit(SO $so)
    {
        $parts = explode('-', $so->name);
        $warehouse = Warehouse::where("code", $parts[0])->firstOrFail();
        $search = request()->query('search');

        if (auth()->user()->role != 'admin' && auth()->user()->location_id != $warehouse->id) {
            return redirect()->back()->with('error', 'You are not allowed to access this page...');
        }

        if ($search) {
            $item = Item::where('warehouse_id', $warehouse->id)->where('itemcode', 'LIKE', "%{$search}%")->firstOrFail();
            if ($item != null) {
                $soItems = SOItem::select('id', 'item_id', 'quantity')->where('so_id', $so->id)->where('item_id', $item->id)->paginate(50);
            } else {
                $soItems = new Collection();
            }
        } else {
            $soItems = SOItem::select('id', 'item_id', 'quantity')->where('so_id', $so->id)->orderBy('created_at', 'asc')->paginate(50);
        }

        $projects = Project::select('id', 'name')->orderBy('id', 'desc')->get();
        $data = compact('so', 'soItems', 'projects');

        return view('sos.edit', $data);
    }

    public function update(SO $so, Request $request)
    {
        $request->validate([
            'date' => 'required|date',
        ]);

        $so->update([
            'description' => $request->description,
            'date' => $request->date,
        ]);

        $text = ucwords(auth()->user()->name) . ' updated ' . $so->name . ", datetime :   " . now();
        Log::create(['text' => $text]);

        return redirect()->route('so')->with('warning', 'SO updated successfully!');
    }

    public function activity(SO $so)
    {
        $search_term1 = " " . trim($so->name) . ",";
        $search_term2 = " " . trim($so->name) . " ";
        $logs = Log::select('text')->where('text', 'LIKE', "%{$search_term1}%")->orWhere('text', 'LIKE', "%{$search_term2}%")->orderBy('id', 'desc')->get();

        $data = compact('so', 'logs');
        return view('sos.activity', $data);
    }

    public function Return(SOItem $soItem)
    {
        $item = Item::findOrFail($soItem->item_id);
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        ModelsRequest::create([
            'user_id' => auth()->user()->id,
            'item_id' => $item->id,
            'so_id' => $soItem->id,
            'quantity' => $soItem->quantity,
            'type' => 10,
            'status' => 0,
            'warehouse_id' => $item->warehouse_id,
        ]);

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
        return redirect()->back()->with('info', 'Request sent!');
    }

    public function return_all($id)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        $soItems = SOItem::where('so_id', $id)->get();
        foreach ($soItems as $soItem) {
            $item = Item::findOrFail($soItem->item_id);

            ModelsRequest::create([
                'user_id' => auth()->user()->id,
                'item_id' => $item->id,
                'so_id' => $soItem->id,
                'quantity' => $soItem->quantity,
                'type' => 10,
                'status' => 0,
                'warehouse_id' => $item->warehouse_id,
            ]);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
        return redirect()->back()->with('info', 'Requests sent!');
    }

    public function AddItems(SO $so)
    {
        $parts = explode('-', $so->name);
        $warehouse = Warehouse::where("code", $parts[0])->firstOrFail();

        if (auth()->user()->role != 'admin' && auth()->user()->location_id != $warehouse->id) {
            return redirect()->back()->with('error', 'You are not allowed to access this page...');
        }

        $so_items = SOItem::select('item_id', 'quantity')->where('so_id', $so->id)->orderBy('created_at', 'desc')->get();
        $requests = ModelsRequest::select('user_id', 'quantity', 'item_id')->where('status', 0)->where('type', 2)->where('so_id', $so->id)->orderBy('created_at', 'DESC')->get();

        $data = compact('so', 'so_items', 'requests');
        return view('sos.add_items', $data);
    }

    public function SaveItems(SO $so, Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.quantity' => 'required|min:1',
        ]);

        $parts = explode('-', $so->name);
        $warehouse = Warehouse::where("code", $parts[0])->firstOrFail();
        $counter = 0;

        foreach ($request->items as $id => $quantity) {
            $item = Item::findOrFail($id);

            if (($item->quantity - $quantity['quantity']) < 0) {
                return redirect()->back()->with('error', 'Item not available...');
            }

            ModelsRequest::create([
                'user_id' => auth()->user()->id,
                'item_id' => $item->id,
                'project_id' => $so->project_id,
                'so_id' => $so->id,
                'quantity' => $quantity['quantity'],
                'warehouse_id' => $warehouse->id,
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
        $so = SO::findOrFail($request->so_id);
        $parts = explode('-', $so->name);
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
        $so = SO::findOrFail($request->so_id);
        $parts = explode('-', $so->name);
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

    public function quantities(SO $so)
    {
        $so_items = SOItem::select('item_id', 'quantity')->where('so_id', $so->id)->get();

        $data = compact('so', 'so_items');
        return view('sos.quantities', $data);
    }

    public function destroy(SO $so)
    {
        $text = ucwords(auth()->user()->name) . " deleted so : " . $so->name . ", datetime :   " . now();

        Log::create(['text' => $text]);
        $so->delete();

        return redirect()->back()->with('error', 'SO deleted successfully!');
    }

    public function new_invoice(SO $so)
    {
        $clients = Client::select('id', 'name', 'tax_id')->get();
        $items = Item::select('id', 'itemcode', 'warehouse_id', 'unit_cost', 'unit_price', 'type')->get();
        $taxes = Tax::select('id', 'name', 'rate')->get();
        $data = compact('clients', 'items', 'taxes', 'so');

        return view('invoices.new', $data);
    }
}
