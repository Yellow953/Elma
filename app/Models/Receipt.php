<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function tax()
    {
        return $this->belongsTo(Tax::class);
    }

    public function purchase_order()
    {
        return $this->belongsTo(PurchaseOrder::class);
    }

    public function items()
    {
        return $this->hasMany(ReceiptItem::class);
    }

    public function payment_vouchers()
    {
        return $this->hasMany(PaymentVoucher::class);
    }

    // Permissions
    public function can_delete()
    {
        return $this->payment_vouchers->count() == 0;
    }

    // Filter
    public function scopeFilter($q)
    {
        if (request('receipt_number')) {
            $receipt_number = request('receipt_number');
            $q->where('receipt_number', 'LIKE', "%{$receipt_number}%");
        }
        if (request('supplier_id')) {
            $supplier_id = request('supplier_id');
            $q->where('supplier_id', $supplier_id);
        }
        if (request('tax_id')) {
            $tax_id = request('tax_id');
            $q->where('tax_id', $tax_id);
        }
        if (request('currency_id')) {
            $currency_id = request('currency_id');
            $q->where('currency_id', $currency_id);
        }
        if (request('date')) {
            $date = request('date');
            $q->where('date', $date);
        }
        if (request('purchase_order_id')) {
            $purchase_order_id = request('purchase_order_id');
            $q->where('purchase_order_id', $purchase_order_id);
        }

        return $q;
    }

    public static function generate_number()
    {
        $year = date('Y');
        $lastReceipt = Receipt::whereYear('created_at', $year)->where('type', 'receipt')->latest()->first();

        if ($lastReceipt) {
            $lastNumber = explode('-', $lastReceipt->receipt_number)[2];
            return 'RCT-' . $year . '-' . ($lastNumber + 1);
        } else {
            return 'RCT-' . $year . '-1';
        }
    }

    public static function generate_return_number()
    {
        $year = date('Y');
        $lastReceipt = Receipt::whereYear('created_at', $year)->where('type', 'return')->latest()->first();

        if ($lastReceipt) {
            $lastNumber = explode('-', $lastReceipt->receipt_number)[3];
            return 'RT-RCT-' . $year . '-' . ($lastNumber + 1);
        } else {
            return 'RT-RCT-' . $year . '-1';
        }
    }
}
