<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $guarded = [];

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

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    // Permissions
    public function can_delete()
    {
        return true;
    }

    // Filter
    public function scopeFilter($q)
    {
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
        if (request('title')) {
            $title = request('title');
            $q->where('title', 'LIKE', "%{$title}%");
        }
        if (request('description')) {
            $description = request('description');
            $q->where('description', 'LIKE', "%{$description}%");
        }

        return $q;
    }
}
