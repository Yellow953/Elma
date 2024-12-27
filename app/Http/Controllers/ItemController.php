<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\SO;
use App\Models\Item;
use App\Models\Log;
use App\Models\PO;
use Carbon\Carbon;
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
        $items = Item::select('id', 'image', 'name', 'quantity', 'leveling', 'itemcode', 'description', 'type', 'inventory_account_id', 'cost_of_sales_account_id', 'sales_account_id')->filter()->orderBy('itemcode', 'ASC')->paginate(25);

        $data = compact('items');
        return view('items.index', $data);
    }

    public function new()
    {
        $accounts = Account::select('id', 'account_number', 'account_description')->get();
        return view('items.new', compact('accounts'));
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'leveling' => 'required|numeric|min:0',
            'itemcode' => 'required|max:255',
            'type' => 'required',
            'inventory_account_id' => 'required|numeric',
            'cost_of_sales_account_id' => 'required|numeric',
            'sales_account_id' => 'required|numeric',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = time() . '.' . $ext;
            $file->move('uploads/items/', $filename);
            $path = '/uploads/items/' . $filename;
        } else {
            $path = '/assets/images/profiles/NoItemImage.png';
        }

        $item = Item::create([
            'name' => $request->name,
            'quantity' => 0,
            'leveling' => $request->leveling,
            'itemcode' => $request->itemcode,
            'description' => $request->description,
            'image' => $path,
            'type' => $request->type,
            'inventory_account_id' => $request->inventory_account_id,
            'cost_of_sales_account_id' => $request->cost_of_sales_account_id,
            'sales_account_id' => $request->sales_account_id,
        ]);

        $text = ucwords(auth()->user()->name) . " created new Item : " . $item->itemcode . ", datetime :   " . now();
        Log::create(['text' => $text]);

        return redirect()->route('items')->with('success', 'Item created successfully!');
    }

    public function edit(Item $item)
    {
        $accounts = Account::select('id', 'account_number', 'account_description')->get();
        $data = compact('accounts', 'item');

        return view('items.edit', $data);
    }

    public function update(Item $item, Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'leveling' => 'required|numeric|min:0',
            'itemcode' => 'required|max:255',
            'type' => 'required',
            'inventory_account_id' => 'required|numeric',
            'cost_of_sales_account_id' => 'required|numeric',
            'sales_account_id' => 'required|numeric',
        ]);

        $item->update(['leveling' => $request->leveling]);

        $items = Item::where('itemcode', $item->itemcode)->get();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = time() . '.' . $ext;
            $file->move('uploads/items/', $filename);
            $path = '/uploads/items/' . $filename;
        } else {
            $path = $item->image;
        }

        foreach ($items as $i) {
            $i->update([
                'name' => $request->name,
                'itemcode' => $request->itemcode,
                'description' => $request->description,
                'image' => $path,
                'type' => $request->type,
                'inventory_account_id' => $request->inventory_account_id,
                'cost_of_sales_account_id' => $request->cost_of_sales_account_id,
                'sales_account_id' => $request->sales_account_id,
            ]);
        }

        $text = ucwords(auth()->user()->name) . ' updated ' . $item->itemcode . ", datetime :   " . now();
        Log::create(['text' => $text]);

        return redirect()->route('items')->with('warning', 'Item updated successfully!');
    }

    public function In(Item $item)
    {
        $pos = PO::select('id', 'name')->orderBy('id', 'desc')->get();

        $data = compact('item', 'pos');
        return view('items.in', $data);
    }

    public function InSave(Item $item, Request $request)
    {
        $request->validate([
            'po_id' => ['required', 'numeric'],
            'quantity' => ['required', 'numeric', 'min:0'],
        ]);

        $po = PO::findOrFail($request->po_id);
        $parts = explode('-', $po->name);

        ModelsRequest::create([
            'item_id' => $item->id,
            'user_id' => auth()->user()->id,
            'quantity' => $request->quantity,
            'type' => 9,
            'status' => 0,
            'po_id' => $po->id,
        ]);

        return redirect()->route('items')->with('info', 'Request sent!');
    }

    public function Out(Item $item)
    {
        $sos = SO::select('id', 'name')->orderBy('id', 'desc')->get();

        $data = compact('item', 'sos');
        return view('items.out', $data);
    }

    public function OutSave(Item $item, Request $request)
    {
        $request->validate([
            'so_id' => ['required', 'numeric'],
            'quantity' => ['required', 'numeric', 'min:0'],
        ]);

        $so = SO::findOrFail($request->so_id);
        $parts = explode('-', $so->name);

        if (($item->quantity - $request->quantity) >= 0) {
            ModelsRequest::create([
                'item_id' => $item->id,
                'user_id' => auth()->user()->id,
                'quantity' => $request->quantity,
                'type' => 2,
                'status' => 0,
                'so_id' => $so->id,
            ]);
        } else {
            return redirect()->back()->with('error', 'Item Empty, Cannot Send Request!');
        }

        return redirect()->route('items')->with('info', 'Request sent!');
    }

    public function activity(Item $item)
    {
        $search_term1 = " " . trim($item->itemcode) . " ";
        $logs = Log::select('text')->where('text', 'LIKE', "%{$search_term1}%")->orderBy('id', 'desc')->get();

        $data = compact('logs', 'item');
        return view('items.activity', $data);
    }

    public function images(Item $item)
    {
        return view('items.images', compact('item'));
    }

    public function destroy(Item $item)
    {
        $items = Item::where('itemcode', $item->itemcode)->get();
        $text = ucwords(auth()->user()->name) . " deleted all items of itemcode : " . $item->itemcode . ", datetime :   " . now();

        foreach ($items as $item) {
            if ($item->can_delete()) {
                $item->delete();
            } else {
                return redirect()->back()->with('error', 'Unothorized Access...');
            }
        }

        Log::create(['text' => $text]);

        return redirect()->back()->with('error', 'Item deleted successfully!');
    }

    public function report(Request $request)
    {
        $request->validate([
            'item_id' => 'required|array',
        ]);

        $itemIds = $request->input('item_id');
        $items = Item::whereIn('id', $itemIds)->get();
        $fromDate = $request->input('from_date') ? Carbon::parse($request->input('from_date'))->startOfDay() : null;
        $toDate = $request->input('to_date') ? Carbon::parse($request->input('to_date'))->endOfDay() : null;

        $reportData = [];
        $totalOverallCost = 0;
        $totalOverallPrice = 0;

        foreach ($items as $item) {
            $invoiceItems = $item->invoice_items()
                ->with('invoice')
                ->when($fromDate, function ($query) use ($fromDate) {
                    return $query->where('created_at', '>=', $fromDate);
                })
                ->when($toDate, function ($query) use ($toDate) {
                    return $query->where('created_at', '<=', $toDate);
                })
                ->get();

            $receiptItems = $item->receipt_items()
                ->with('receipt')
                ->when($fromDate, function ($query) use ($fromDate) {
                    return $query->where('created_at', '>=', $fromDate);
                })
                ->when($toDate, function ($query) use ($toDate) {
                    return $query->where('created_at', '<=', $toDate);
                })
                ->get();

            $combinedData = [];
            $totalItemCost = 0;
            $totalItemPrice = 0;

            foreach ($receiptItems as $receiptItem) {
                $combinedData[] = [
                    'type' => 'Receipt',
                    'name' => $receiptItem->receipt->receipt_number,
                    'quantity' => $receiptItem->quantity,
                    'unit_price' => '',
                    'unit_cost' => $receiptItem->unit_cost,
                    'total_price' => '',
                    'total_cost' => $receiptItem->total_cost,
                    'date' => $receiptItem->created_at,
                ];
            }

            foreach ($invoiceItems as $invoiceItem) {
                $combinedData[] = [
                    'type' => 'Invoice',
                    'name' => $invoiceItem->invoice->invoice_number,
                    'quantity' => $invoiceItem->quantity,
                    'unit_price' => $invoiceItem->unit_price,
                    'unit_cost' => $invoiceItem->unit_cost,
                    'total_price' => $invoiceItem->total_price,
                    'total_cost' => $invoiceItem->total_cost,
                    'date' => $invoiceItem->created_at,
                ];
                $totalItemCost += $invoiceItem->total_cost;
                $totalItemPrice += $invoiceItem->total_price;
            }

            // Sort combined data by date
            usort($combinedData, function ($a, $b) {
                return strtotime($a['date']) - strtotime($b['date']);
            });

            $reportData[$item->id] = [
                'item' => $item,
                'combinedData' => $combinedData,
                'totalItemCost' => $totalItemCost,
                'totalItemPrice' => $totalItemPrice,
            ];

            $totalOverallCost += $totalItemCost;
            $totalOverallPrice += $totalItemPrice;
        }

        $data = [
            'reportData' => $reportData,
            'totalOverallCost' => $totalOverallCost,
            'totalOverallPrice' => $totalOverallPrice,
            'fromDate' => $fromDate,
            'toDate' => $toDate,
        ];

        return view('items.report_result', $data);
    }

    public function item_report(Item $item)
    {
        $CombinedData = [];
        $total_cost = 0;
        $total_price = 0;

        $invoiceItems = $item->invoice_items()->get();
        $receiptItems = $item->receipt_items()->get();

        if ($invoiceItems->count() != 0 || $receiptItems->count() != 0) {
            foreach ($receiptItems as $receiptItem) {
                $rowData = [
                    'type' =>  'Receipt',
                    'name' => $receiptItem->receipt->receipt_number,
                    'item_name' => $receiptItem->item->name,
                    'quantity' => $receiptItem->quantity,
                    'unit_price' => '',
                    'unit_cost' => $receiptItem->unit_cost,
                    'total_price' => '',
                    'total_cost' => $receiptItem->total_cost,
                    'date' => $receiptItem->created_at,
                ];

                $CombinedData[] = $rowData;
            }
            foreach ($invoiceItems as $invoiceItem) {
                $rowData = [
                    'type' =>  'Invoice',
                    'name' => $invoiceItem->invoice->invoice_number,
                    'item_name' => $invoiceItem->item->name,
                    'quantity' => $invoiceItem->quantity,
                    'unit_price' => $invoiceItem->unit_price,
                    'unit_cost' => $invoiceItem->unit_cost,
                    'total_price' => $invoiceItem->total_price,
                    'total_cost' => $invoiceItem->total_cost,
                    'date' => $invoiceItem->created_at,
                ];

                $CombinedData[] = $rowData;
                $total_cost += $invoiceItem->total_cost;
                $total_price += $invoiceItem->total_price;
            }

            usort($CombinedData, function ($a, $b) {
                return strtotime($a['date']) - strtotime($b['date']);
            });

            $data = compact('item', 'CombinedData', 'total_cost', 'total_price');

            return view('items.report_result', $data);
        } else {
            return redirect()->back()->with('warning', 'Report Unavailable for this Item due to the lack of Activity...');
        }
    }

    public function report_page()
    {
        return view('items.report');
    }

    public function barcodes(Item $item)
    {
        $barcodes = $item->barcodes()->get();

        $barcodeData = [];
        foreach ($barcodes as $barcode) {
            $barcodeData[] = [
                'barcode' => $barcode->barcode,
            ];
        }

        return response()->json(['barcodes' => $barcodeData]);
    }

    public function track(Request $request)
    {
        $item = Item::findOrFail($request->item_id);
        if ($item->type == 'Serialized') {
            $serial_number = $request->serial_number;
            $result = $item->barcodes()->where('barcode', $serial_number)->get();

            if ($result->count() != 0) {
                return view('items.track_result', compact('item', 'serial_number', 'result'));
            } else {
                return redirect()->back()->with('warning', 'No Such Serial Number for this Item...');
            }
        } else {
            return redirect()->back()->with('warning', 'Item Not Serialized...');
        }
    }

    public function track_page()
    {
        return view('items.track');
    }
}
