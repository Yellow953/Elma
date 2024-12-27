<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VOC extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id');
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

    public function voc_items()
    {
        return $this->hasMany(VOCItem::class, 'voc_id');
    }

    // Permissions
    public function can_delete()
    {
        return $this->voc_items->count() == 0;
    }

    public function can_edit()
    {
        return $this->journal_voucher->status == 'unposted';
    }

    // Filter
    public function scopeFilter($q)
    {
        if (request('voc_number')) {
            $voc_number = request('voc_number');
            $q->where('voc_number', 'LIKE', "%{$voc_number}%");
        }
        if (request('description')) {
            $description = request('description');
            $q->where('description', 'LIKE', "%{$description}%");
        }
        if (request('supplier_id')) {
            $supplier_id = request('supplier_id');
            $q->where('supplier_id', $supplier_id);
        }
        if (request('supplier_invoice')) {
            $supplier_invoice = request('supplier_invoice');
            $q->where('supplier_invoice', 'LIKE', "%{$supplier_invoice}%");
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

        return $q;
    }

    public static function generate_number()
    {
        $year = date('Y');
        $lastVOC = VOC::whereYear('created_at', $year)->where('type', '!=', 'return')->latest()->first();

        if ($lastVOC) {
            $lastNumber = explode('-', $lastVOC->voc_number)[2];
            return 'VOC-' . $year . '-' . ($lastNumber + 1);
        } else {
            return 'VOC-' . $year . '-1';
        }
    }

    public static function generate_return_number()
    {
        $year = date('Y');
        $lastVOC = VOC::whereYear('created_at', $year)->where('type', 'return')->latest()->first();

        if ($lastVOC) {
            $lastNumber = explode('-', $lastVOC->voc_number)[3];
            return 'RT-VOC-' . $year . '-' . ($lastNumber + 1);
        } else {
            return 'RT-VOC-' . $year . '-1';
        }
    }
}
