<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\Log;
use App\Models\PaymentVoucher;
use App\Models\PaymentVoucherItem;
use App\Models\Receipt;
use App\Models\Supplier;
use Illuminate\Http\Request;

class PaymentVoucherController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:payment_vouchers.read')->only(['index', 'show']);
        $this->middleware('permission:payment_vouchers.create')->only(['new', 'create']);
        $this->middleware('permission:payment_vouchers.update')->only(['edit', 'update']);
        $this->middleware('permission:payment_vouchers.delete')->only(['destroy', 'item_destroy']);
    }

    public function index()
    {
        $payment_vouchers = PaymentVoucher::select('id', 'number', 'supplier_id', 'date', 'total', 'currency_id')->filter()->orderBy('id', 'desc')->paginate(25);
        $suppliers = Supplier::select('id', 'name')->get();
        $receipts = Receipt::select('id', 'receipt_number')->get();
        $currencies = Currency::select('id', 'code')->get();

        $data = compact('payment_vouchers', 'suppliers', 'receipts', 'currencies');
        return view('payment_vouchers.index', $data);
    }

    public function new()
    {
        $suppliers = Supplier::select('id', 'name')->get();
        $receipts = Receipt::select('id', 'receipt_number')->get();
        $currencies = Currency::select('id', 'code')->get();

        $data = compact('suppliers', 'receipts', 'currencies');
        return view('payment_vouchers.new', $data);
    }

    public function create(Request $request)
    {
        $request->validate([
            'number' => 'required|unique:payment_vouchers,number',
            'supplier_id' => 'required|exists:suppliers,id',
            'receipt_id' => 'nullable|exists:receipts,id',
            'currency_id' => 'required|exists:currencies,id',
            'date' => 'required|date',
            'description.*' => 'required|string',
            'amount.*' => 'required|numeric',
        ]);

        // $number = PaymentVoucher::generate_number();
        $total = 0;

        $payment_voucher = PaymentVoucher::create([
            'number' => $request->number,
            'supplier_id' => $request->supplier_id,
            'receipt_id' => $request->receipt_id ?? null,
            'currency_id' => $request->currency_id,
            'date' => $request->date,
        ]);

        foreach ($request->description as $index => $description) {
            PaymentVoucherItem::create([
                'payment_voucher_id' => $payment_voucher->id,
                'description' => $request->description[$index],
                'amount' => $request->amount[$index],
            ]);
            $total += $request->amount[$index];
        }

        $payment_voucher->update(['total' => $total]);

        $text = ucwords(auth()->user()->name) . " created new Payment Voucher : " . $payment_voucher->number . ", datetime : " . now();
        Log::create(['text' => $text]);

        return redirect()->route('payment_vouchers')->with('success', 'Payment Voucher created successfully!');
    }

    public function edit(PaymentVoucher $payment_voucher)
    {
        return view('payment_vouchers.edit', compact('payment_voucher'));
    }

    public function update(PaymentVoucher $payment_voucher, Request $request)
    {
        $request->validate([
            'date' => 'required|date',
        ]);

        $payment_voucher->update([
            'date' => $request->date,
        ]);

        if ($request->description[0] != '' && $request->description[0] != null) {
            $total = $payment_voucher->total;

            foreach ($request->description as $index => $description) {
                PaymentVoucherItem::create([
                    'payment_voucher_id' => $payment_voucher->id,
                    'description' => $request->description[$index],
                    'amount' => $request->amount[$index],
                ]);
                $total += $request->amount[$index];
            }

            $payment_voucher->update(['total' => $total]);
        }

        $text = ucwords(auth()->user()->name) . ' updated Payment Voucher ' . $payment_voucher->number . ", datetime :   " . now();
        Log::create(['text' => $text]);

        return redirect()->back()->with('warning', 'Payment Voucher updated successfully!');
    }

    public function show(PaymentVoucher $payment_voucher)
    {
        $data = compact('payment_voucher');
        return view('payment_vouchers.show', $data);
    }

    public function destroy(PaymentVoucher $payment_voucher)
    {
        if ($payment_voucher->can_delete()) {
            $text = ucwords(auth()->user()->name) . " deleted payment voucher : " . $payment_voucher->number . ", datetime :   " . now();

            foreach ($payment_voucher->items as $item) {
                $item->delete();
            }

            Log::create(['text' => $text]);
            $payment_voucher->delete();

            return redirect()->back()->with('error', 'Payment Voucher deleted successfully!');
        } else {
            return redirect()->back()->with('error', 'Unable to delete...');
        }
    }

    public function item_destroy(PaymentVoucherItem $payment_voucher_item)
    {
        $payment_voucher = $payment_voucher_item->payment_voucher;

        $text = ucwords(auth()->user()->name) . " corrected Payment Voucher : " . $payment_voucher->number . ", datetime :   " . now();

        $payment_voucher->update([
            'total' => $payment_voucher->total - $payment_voucher_item->amount,
        ]);

        $payment_voucher_item->delete();
        Log::create(['text' => $text]);

        return redirect()->back()->with('success', 'Pasyment Voucher Item deleted successfully!');
    }
}
