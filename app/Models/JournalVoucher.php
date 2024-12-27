<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JournalVoucher extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function transactions()
    {
        return $this->hasMany(Transaction::class)->where('hidden', false);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }

    public function foreign_currency()
    {
        return $this->belongsTo(Currency::class, 'foreign_currency_id');
    }

    public function receipt()
    {
        return $this->hasOne(Receipt::class, 'journal_voucher_id');
    }

    public function voc()
    {
        return $this->hasOne(VOC::class, 'journal_voucher_id');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class, 'journal_voucher_id');
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class, 'journal_voucher_id');
    }

    public function cdnote()
    {
        return $this->hasOne(CDNote::class, 'journal_voucher_id');
    }

    // Permissions
    public function can_delete()
    {
        return $this->invoice == null && $this->payment == null && $this->voc == null && $this->receipt == null && $this->cdnote == null;
    }

    // Filter
    public function scopeFilter($q)
    {
        if (request('id')) {
            $id = request('id');
            $q->where('id', $id);
        }
        if (request('date')) {
            $date = request('date');
            $q->where('date', $date);
        }
        if (request('description')) {
            $description = request('description');
            $q->where('description', 'LIKE', "%{$description}%");
        }
        if (request('status')) {
            $status = request('status');
            $q->where('status', 'LIKE', "%{$status}%");
        }
        if (request('user_id')) {
            $user_id = request('user_id');
            $q->where('user_id', $user_id);
        }
        if (request('currency_id')) {
            $currency_id = request('currency_id');
            $q->where('currency_id', $currency_id);
        }
        if (request('foreign_currency_id')) {
            $foreign_currency_id = request('foreign_currency_id');
            $q->where('foreign_currency_id', $foreign_currency_id);
        }
        if (request('source')) {
            $source = request('source');
            $q->where('source', 'LIKE', "%{$source}%");
        }
        if (request('batch')) {
            $batch = request('batch');
            $q->where('batch', 'LIKE', "%{$batch}%");
        }

        return $q;
    }
}
