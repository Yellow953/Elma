<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentVoucher extends Model
{
    protected $guarded = [];

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function receipt()
    {
        return $this->belongsTo(Receipt::class);
    }

    public function items()
    {
        return $this->hasMany(PaymentVoucherItem::class);
    }

    // Permissions
    public function can_delete()
    {
        return true;
    }

    // Filter
    public function scopeFilter($q)
    {
        if (request('number')) {
            $number = request('number');
            $q->where('number', 'LIKE', "%{$number}%");
        }
        if (request('supplier_id')) {
            $supplier_id = request('supplier_id');
            $q->where('supplier_id', $supplier_id);
        }
        if (request('currency_id')) {
            $currency_id = request('currency_id');
            $q->where('currency_id', $currency_id);
        }
        if (request('date')) {
            $date = request('date');
            $q->where('date', $date);
        }
        if (request('receipt_id')) {
            $receipt_id = request('receipt_id');
            $q->where('receipt_id', $receipt_id);
        }

        return $q;
    }

    public static function generate_number()
    {
        $year = date('Y');
        $lastPaymentVoucher = PaymentVoucher::whereYear('created_at', $year)->latest()->first();

        if ($lastPaymentVoucher) {
            $lastNumber = explode('-', $lastPaymentVoucher->number)[2];
            return 'PV-' . $year . '-' . ($lastNumber + 1);
        } else {
            return 'PV-' . $year . '-1';
        }
    }
}
