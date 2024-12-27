<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function journal_voucher()
    {
        return $this->belongsTo(JournalVoucher::class, 'journal_voucher_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }

    public function foreign_currency()
    {
        return $this->belongsTo(Currency::class, 'foreign_currency_id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    // Filter
    public function scopeFilter($q)
    {
        if (request('journal_voucher_id')) {
            $journal_voucher_id = request('journal_voucher_id');
            $q->where('journal_voucher_id', $journal_voucher_id);
        }
        if (request('account_id')) {
            $account_id = request('account_id');
            $q->where('account_id', $account_id);
        }
        if (request('user_id')) {
            $user_id = request('user_id');
            $q->where('user_id', $user_id);
        }
        if (request('currency_id')) {
            $currency_id = request('currency_id');
            $q->where('currency_id', $currency_id);
        }
        if (request('debit')) {
            $debit = request('debit');
            $q->where('debit', $debit);
        }
        if (request('credit')) {
            $credit = request('credit');
            $q->where('credit', $credit);
        }
        if (request('balance')) {
            $balance = request('balance');
            $q->where('balance', $balance);
        }
        if (request('foreign_currency_id')) {
            $foreign_currency_id = request('foreign_currency_id');
            $q->where('foreign_currency_id', $foreign_currency_id);
        }
        if (request('foreign_debit')) {
            $foreign_debit = request('foreign_debit');
            $q->where('foreign_debit', $foreign_debit);
        }
        if (request('foreign_credit')) {
            $foreign_credit = request('foreign_credit');
            $q->where('foreign_credit', $foreign_credit);
        }
        if (request('foreign_balance')) {
            $foreign_balance = request('foreign_balance');
            $q->where('foreign_balance', $foreign_balance);
        }
        if (request('rate')) {
            $rate = request('rate');
            $q->where('rate', $rate);
        }

        return $q;
    }
}
