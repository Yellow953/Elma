<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CDNote extends Model
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

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function tax()
    {
        return $this->belongsTo(Tax::class);
    }

    public function journal_voucher()
    {
        return $this->belongsTo(JournalVoucher::class);
    }

    public function cdnote_items()
    {
        return $this->hasMany(CDNoteItem::class, 'cdnote_id');
    }

    // Permissions
    public function can_delete()
    {
        return $this->cdnote_items->count() == 0;
    }

    public function can_edit()
    {
        return $this->journal_voucher->status == 'unposted';
    }

    // Filter
    public function scopeFilter($q)
    {
        if (request('cdnote_number')) {
            $cdnote_number = request('cdnote_number');
            $q->where('cdnote_number', 'LIKE', "%{$cdnote_number}%");
        }
        if (request('description')) {
            $description = request('description');
            $q->where('description', 'LIKE', "%{$description}%");
        }
        if (request('supplier_id')) {
            $supplier_id = request('supplier_id');
            $q->where('supplier_id', $supplier_id);
        }
        if (request('client_id')) {
            $client_id = request('client_id');
            $q->where('client_id', $client_id);
        }
        if (request('currency_id')) {
            $currency_id = request('currency_id');
            $q->where('currency_id', $currency_id);
        }
        if (request('foreign_currency_id')) {
            $foreign_currency_id = request('foreign_currency_id');
            $q->where('foreign_currency_id', $foreign_currency_id);
        }
        if (request('journal_voucher_id')) {
            $journal_voucher_id = request('journal_voucher_id');
            $q->where('journal_voucher_id', $journal_voucher_id);
        }
        if (request('date')) {
            $date = request('date');
            $q->where('date', $date);
        }
        if (request('tax_id')) {
            $tax_id = request('tax_id');
            $q->where('tax_id', $tax_id);
        }

        return $q;
    }

    public static function generate_number($type)
    {
        $year = date('Y');
        if ($type == 'credit note') {
            $lastCDNote = CDNote::whereYear('created_at', $year)->where('type', 'credit note')->latest()->first();

            if ($lastCDNote) {
                $lastNumber = explode('-', $lastCDNote->cdnote_number)[2];
                return 'CDT-' . $year . '-' . ($lastNumber + 1);
            } else {
                return 'CDT-' . $year . '-1';
            }
        } else if ($type == 'debit note') {
            $lastCDNote = CDNote::whereYear('created_at', $year)->where('type', 'debit note')->latest()->first();

            if ($lastCDNote) {
                $lastNumber = explode('-', $lastCDNote->cdnote_number)[2];
                return 'DBT-' . $year . '-' . ($lastNumber + 1);
            } else {
                return 'DBT-' . $year . '-1';
            }
        }
    }
}
