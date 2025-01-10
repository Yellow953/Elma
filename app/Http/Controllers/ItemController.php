<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Log;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:items.read')->only(['index', 'activity']);
        $this->middleware('permission:items.create')->only(['new', 'create']);
        $this->middleware('permission:items.update')->only(['edit', 'update']);
        $this->middleware('permission:items.delete')->only('destroy');
        $this->middleware('permission:items.export')->only('export');
    }

    public function index()
    {
        $items = Item::select('id', 'name', 'description', 'unit_price', 'unit', 'type')->filter()->orderBy('id', 'ASC')->paginate(25);

        return view('items.index', compact('items'));
    }

    public function new()
    {
        return view('items.new');
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable|string',
            'unit_price' => 'required|numeric|min:0',
            'unit' => 'nullable|string|max:50',
            'type' => 'required|string|max:255',
        ]);

        $item = Item::create([
            'name' => $request->name,
            'description' => $request->description,
            'unit_price' => $request->unit_price,
            'unit' => $request->unit,
            'type' => $request->type,
        ]);

        $text = ucwords(auth()->user()->name) . " created a new Item: " . $item->name . ", datetime: " . now();
        Log::create(['text' => $text]);

        return redirect()->route('items')->with('success', 'Item created successfully!');
    }

    public function edit(Item $item)
    {
        return view('items.edit', compact('item'));
    }

    public function update(Request $request, Item $item)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable|string',
            'unit_price' => 'required|numeric|min:0',
            'unit' => 'nullable|string|max:50',
            'type' => 'required|string|max:255',
        ]);

        $item->update([
            'name' => $request->name,
            'description' => $request->description,
            'unit_price' => $request->unit_price,
            'unit' => $request->unit,
            'type' => $request->type,
        ]);

        $text = ucwords(auth()->user()->name) . " updated Item: " . $item->name . ", datetime: " . now();
        Log::create(['text' => $text]);

        return redirect()->route('items')->with('warning', 'Item updated successfully!');
    }

    public function activity(Item $item)
    {
        $search_term1 = " " . trim($item->name) . " ";
        $logs = Log::select('text')->where('text', 'LIKE', "%{$search_term1}%")->orderBy('id', 'desc')->get();

        $data = compact('logs', 'item');
        return view('items.activity', $data);
    }

    public function destroy(Item $item)
    {
        if ($item->can_delete()) {
            $text = ucwords(auth()->user()->name) . " deleted Item: " . $item->name . ", datetime: " . now();
            Log::create(['text' => $text]);

            $item->delete();

            return redirect()->route('items')->with('error', 'Item deleted successfully!');
        } else {
            return redirect()->back()->with('error', 'Unable to delete...');
        }
    }
}
