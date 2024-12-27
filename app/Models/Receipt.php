<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Receipt extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function foreign_currency()
    {
        return $this->belongsTo(Currency::class, 'foreign_currency_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function tax()
    {
        return $this->belongsTo(Tax::class);
    }

    public function journal_voucher()
    {
        return $this->belongsTo(JournalVoucher::class);
    }

    public function po()
    {
        return $this->belongsTo(PO::class);
    }

    public function receipt_items()
    {
        return $this->hasMany(ReceiptItem::class);
    }

    public function landed_costs()
    {
        return $this->hasMany(LandedCost::class);
    }

    public function barcodes()
    {
        return $this->hasMany(BarcodeItem::class);
    }

    // Permissions
    public function can_delete()
    {
        return $this->receipt_items->count() == 0 && $this->landed_costs->count() == 0;
    }

    public function can_edit()
    {
        return $this->journal_voucher->status == 'unposted';
    }

    // Filter
    public function scopeFilter($q)
    {
        if (request('receipt_number')) {
            $receipt_number = request('receipt_number');
            $q->where('receipt_number', 'LIKE', "%{$receipt_number}%");
        }
        if (request('supplier_invoice')) {
            $supplier_invoice = request('supplier_invoice');
            $q->where('supplier_invoice', 'LIKE', "%{$supplier_invoice}%");
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
        if (request('foreign_currency_id')) {
            $foreign_currency_id = request('foreign_currency_id');
            $q->where('foreign_currency_id', $foreign_currency_id);
        }
        if (request('date')) {
            $date = request('date');
            $q->where('date', $date);
        }
        if (request('journal_voucher_id')) {
            $journal_voucher_id = request('journal_voucher_id');
            $q->where('journal_voucher_id', $journal_voucher_id);
        }
        if (request('po_id')) {
            $po_id = request('po_id');
            $q->where('po_id', $po_id);
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