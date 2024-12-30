<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Item;
use App\Models\Log;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:items.read')->only('index');
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

        return redirect()->route('items.index')->with('success', 'Item created successfully!');
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

        return redirect()->route('items.index')->with('warning', 'Item updated successfully!');
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
        $text = ucwords(auth()->user()->name) . " deleted Item: " . $item->name . ", datetime: " . now();
        Log::create(['text' => $text]);

        $item->delete();

        return redirect()->route('items.index')->with('error', 'Item deleted successfully!');
    }

    // public function report(Request $request)
    // {
    //     $request->validate([
    //         'item_id' => 'required|array',
    //     ]);

    //     $itemIds = $request->input('item_id');
    //     $items = Item::whereIn('id', $itemIds)->get();
    //     $fromDate = $request->input('from_date') ? Carbon::parse($request->input('from_date'))->startOfDay() : null;
    //     $toDate = $request->input('to_date') ? Carbon::parse($request->input('to_date'))->endOfDay() : null;

    //     $reportData = [];
    //     $totalOverallCost = 0;
    //     $totalOverallPrice = 0;

    //     foreach ($items as $item) {
    //         $invoiceItems = $item->invoice_items()
    //             ->with('invoice')
    //             ->when($fromDate, function ($query) use ($fromDate) {
    //                 return $query->where('created_at', '>=', $fromDate);
    //             })
    //             ->when($toDate, function ($query) use ($toDate) {
    //                 return $query->where('created_at', '<=', $toDate);
    //             })
    //             ->get();

    //         $receiptItems = $item->receipt_items()
    //             ->with('receipt')
    //             ->when($fromDate, function ($query) use ($fromDate) {
    //                 return $query->where('created_at', '>=', $fromDate);
    //             })
    //             ->when($toDate, function ($query) use ($toDate) {
    //                 return $query->where('created_at', '<=', $toDate);
    //             })
    //             ->get();

    //         $combinedData = [];
    //         $totalItemCost = 0;
    //         $totalItemPrice = 0;

    //         foreach ($receiptItems as $receiptItem) {
    //             $combinedData[] = [
    //                 'type' => 'Receipt',
    //                 'name' => $receiptItem->receipt->receipt_number,
    //                 'quantity' => $receiptItem->quantity,
    //                 'unit_price' => '',
    //                 'unit_cost' => $receiptItem->unit_cost,
    //                 'total_price' => '',
    //                 'total_cost' => $receiptItem->total_cost,
    //                 'date' => $receiptItem->created_at,
    //             ];
    //         }

    //         foreach ($invoiceItems as $invoiceItem) {
    //             $combinedData[] = [
    //                 'type' => 'Invoice',
    //                 'name' => $invoiceItem->invoice->invoice_number,
    //                 'quantity' => $invoiceItem->quantity,
    //                 'unit_price' => $invoiceItem->unit_price,
    //                 'unit_cost' => $invoiceItem->unit_cost,
    //                 'total_price' => $invoiceItem->total_price,
    //                 'total_cost' => $invoiceItem->total_cost,
    //                 'date' => $invoiceItem->created_at,
    //             ];
    //             $totalItemCost += $invoiceItem->total_cost;
    //             $totalItemPrice += $invoiceItem->total_price;
    //         }

    //         // Sort combined data by date
    //         usort($combinedData, function ($a, $b) {
    //             return strtotime($a['date']) - strtotime($b['date']);
    //         });

    //         $reportData[$item->id] = [
    //             'item' => $item,
    //             'combinedData' => $combinedData,
    //             'totalItemCost' => $totalItemCost,
    //             'totalItemPrice' => $totalItemPrice,
    //         ];

    //         $totalOverallCost += $totalItemCost;
    //         $totalOverallPrice += $totalItemPrice;
    //     }

    //     $data = [
    //         'reportData' => $reportData,
    //         'totalOverallCost' => $totalOverallCost,
    //         'totalOverallPrice' => $totalOverallPrice,
    //         'fromDate' => $fromDate,
    //         'toDate' => $toDate,
    //     ];

    //     return view('items.report_result', $data);
    // }

    // public function item_report(Item $item)
    // {
    //     $CombinedData = [];
    //     $total_cost = 0;
    //     $total_price = 0;

    //     $invoiceItems = $item->invoice_items()->get();
    //     $receiptItems = $item->receipt_items()->get();

    //     if ($invoiceItems->count() != 0 || $receiptItems->count() != 0) {
    //         foreach ($receiptItems as $receiptItem) {
    //             $rowData = [
    //                 'type' =>  'Receipt',
    //                 'name' => $receiptItem->receipt->receipt_number,
    //                 'item_name' => $receiptItem->item->name,
    //                 'quantity' => $receiptItem->quantity,
    //                 'unit_price' => '',
    //                 'unit_cost' => $receiptItem->unit_cost,
    //                 'total_price' => '',
    //                 'total_cost' => $receiptItem->total_cost,
    //                 'date' => $receiptItem->created_at,
    //             ];

    //             $CombinedData[] = $rowData;
    //         }
    //         foreach ($invoiceItems as $invoiceItem) {
    //             $rowData = [
    //                 'type' =>  'Invoice',
    //                 'name' => $invoiceItem->invoice->invoice_number,
    //                 'item_name' => $invoiceItem->item->name,
    //                 'quantity' => $invoiceItem->quantity,
    //                 'unit_price' => $invoiceItem->unit_price,
    //                 'unit_cost' => $invoiceItem->unit_cost,
    //                 'total_price' => $invoiceItem->total_price,
    //                 'total_cost' => $invoiceItem->total_cost,
    //                 'date' => $invoiceItem->created_at,
    //             ];

    //             $CombinedData[] = $rowData;
    //             $total_cost += $invoiceItem->total_cost;
    //             $total_price += $invoiceItem->total_price;
    //         }

    //         usort($CombinedData, function ($a, $b) {
    //             return strtotime($a['date']) - strtotime($b['date']);
    //         });

    //         $data = compact('item', 'CombinedData', 'total_cost', 'total_price');

    //         return view('items.report_result', $data);
    //     } else {
    //         return redirect()->back()->with('warning', 'Report Unavailable for this Item due to the lack of Activity...');
    //     }
    // }

    // public function report_page()
    // {
    //     return view('items.report');
    // }
}
