<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\InvoiceItem;
use App\Models\SO;
use App\Models\Item;
use App\Models\Log;
use App\Models\PO;
use App\Models\ReceiptItem;
use App\Models\Req;
use App\Models\Request as ModelsRequest;
use App\Models\TRO;
use App\Models\Warehouse;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('setup');
        $this->middleware('agreed');
        $this->middleware('admin')->only('destroy');
    }

    public function index()
    {
        $items = Item::select('id', 'image', 'name', 'quantity', 'leveling', 'itemcode', 'description', 'type', 'inventory_account_id', 'cost_of_sales_account_id', 'sales_account_id', 'warehouse_id')->filter()->orderBy('itemcode', 'ASC')->paginate(25);

        $data = compact('items');
        return view('items.index', $data);
    }

    public function index_warehouse($warehouse)
    {
        $warehouse = Warehouse::where('name', $warehouse)->firstOrFail();

        $items = Item::select('id', 'image', 'name', 'quantity', 'leveling', 'itemcode', 'description', 'type', 'inventory_account_id', 'cost_of_sales_account_id', 'sales_account_id', 'warehouse_id')->where('warehouse_id', $warehouse->id)->filter()->orderBy('itemcode', 'ASC')->paginate(25);

        $data = compact('items', 'warehouse');
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
            'warehouses' => 'required|array',
            'warehouses.*' => 'exists:warehouses,id',
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

        $warehouses_text = "";

        foreach ($request->warehouses as $w) {
            $warehouse = Warehouse::find($w);
            $warehouses_text .= " " . ucwords($warehouse->name);
            $item = Item::create([
                'name' => $request->name,
                'quantity' => 0,
                'leveling' => $request->leveling,
                'warehouse_id' => $warehouse->id,
                'itemcode' => $request->itemcode,
                'description' => $request->description,
                'image' => $path,
                'type' => $request->type,
                'inventory_account_id' => $request->inventory_account_id,
                'cost_of_sales_account_id' => $request->cost_of_sales_account_id,
                'sales_account_id' => $request->sales_account_id,
            ]);
        }

        $text = ucwords(auth()->user()->name) . " created new Item : " . $item->itemcode . " for warehouses:" . $warehouses_text . ", datetime :   " . now();
        Log::create(['text' => $text]);

        return redirect()->route('items', auth()->user()->location->name)->with('success', 'Item created successfully!');
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

        return redirect()->route('items', $item->warehouse->name)->with('warning', 'Item updated successfully!');
    }

    public function In(Item $item)
    {
        if (auth()->user()->role == 'admin') {
            $pos = PO::select('id', 'name')->orderBy('id', 'desc')->get();
        } else {
            $warehouse = auth()->user()->location;
            $pos = PO::select('id', 'name')->where('name', 'LIKE', "%{$warehouse->code}%")->orderBy('id', 'desc')->get();
        }

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
        $warehouse = Warehouse::where("code", $parts[0])->firstOrFail();

        ModelsRequest::create([
            'item_id' => $item->id,
            'user_id' => auth()->user()->id,
            'quantity' => $request->quantity,
            'type' => 9,
            'status' => 0,
            'warehouse_id' => $warehouse->id,
            'po_id' => $po->id,
        ]);

        return redirect()->route('items', $item->warehouse->name)->with('info', 'Request sent!');
    }

    public function Out(Item $item)
    {
        if (auth()->user()->role == 'admin') {
            $sos = SO::select('id', 'name')->orderBy('id', 'desc')->get();
        } else {
            $warehouse = auth()->user()->location;
            $sos = SO::select('id', 'name')->where('name', 'LIKE', "%{$warehouse->code}%")->orderBy('id', 'desc')->get();
        }

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
        $warehouse = Warehouse::where("code", $parts[0])->firstOrFail();

        if (($item->quantity - $request->quantity) >= 0) {
            ModelsRequest::create([
                'item_id' => $item->id,
                'user_id' => auth()->user()->id,
                'project_id' => $so->project->id,
                'quantity' => $request->quantity,
                'type' => 2,
                'status' => 0,
                'warehouse_id' => $warehouse->id,
                'so_id' => $so->id,
            ]);
        } else {
            return redirect()->back()->with('error', 'Item Empty, Cannot Send Request!');
        }

        return redirect()->route('items', $item->warehouse->name)->with('info', 'Request sent!');
    }

    public function Transfer(Item $item)
    {
        if (auth()->user()->role == 'admin') {
            $tros = TRO::select('id', 'name')->orderBy('id', 'desc')->get();
        } else {
            $tros = TRO::select('id', 'name')->where('from_id', auth()->user()->location_id)->orWhere('to_id', auth()->user()->location_id)->orderBy('id', 'desc')->get();
        }

        $data = compact('item', 'tros');
        return view('items.transfer', $data);
    }

    public function TransferSave(Item $item, Request $request)
    {
        $request->validate([
            'tro_id' => ['required', 'numeric'],
            'quantity' => ['required', 'numeric', 'min:0'],
        ]);

        $tro = TRO::findOrFail($request->tro_id);

        if (($item->quantity - $request->quantity) >= 0) {
            Req::create([
                'user_id' => auth()->user()->id,
                'item_id' => $item->id,
                'quantity' => $request->quantity,
                'from_id' => $tro->from_id,
                'to_id' => $tro->to_id,
                'tro_id' => $tro->id,
                'type' => 0,
            ]);
        } else {
            return redirect()->back()->with('error', 'Item Empty, Cannot Send Request!');
        }

        return redirect()->route('items', $item->warehouse->name)->with('info', 'Request sent!');
    }

    public function activity(Item $item)
    {
        $search_term1 = " " . trim($item->itemcode) . " ";
        $logs = Log::select('text')->where('text', 'LIKE', "%{$item->warehouse->name}%")->where('text', 'LIKE', "%{$search_term1}%")->orderBy('id', 'desc')->get();

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
        $text = ucwords(auth()->user()->name) . " deleted all items of itemcode : " . $item->itemcode . " from all warehouses, datetime :   " . now();

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
