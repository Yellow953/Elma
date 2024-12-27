<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class)->where('hidden', false);
    }

    public function client()
    {
        return $this->hasOne(Client::class);
    }

    public function supplier()
    {
        return $this->hasOne(Supplier::class);
    }

    public function tax()
    {
        return $this->hasOne(Tax::class);
    }

    public function inventory_items()
    {
        return $this->hasMany(Item::class, 'inventory_account_id');
    }

    public function cost_of_sales_items()
    {
        return $this->hasMany(Item::class, 'cost_of_sales_account_id');
    }

    public function sales_items()
    {
        return $this->hasMany(Item::class, 'sales_account_id');
    }

    // Permissions
    public function can_delete()
    {
        return $this->transactions->count() == 0 && $this->client == null && $this->supplier == null && $this->tax == null && $this->inventory_items->count() == 0 && $this->cost_of_sales_items->count() == 0 && $this->sales_items->count() == 0;
    }

    // Filter
    public function scopeFilter($q)
    {
        if (request('account_number')) {
            $account_number = request('account_number');
            $q->where('account_number', 'LIKE', "%{$account_number}%");
        }
        if (request('account_description')) {
            $account_description = request('account_description');
            $q->where('account_description', 'LIKE', "%{$account_description}%");
        }
        if (request('type')) {
            $type = request('type');
            $q->where('type', 'LIKE', "%{$type}%");
        }
        if (request('sub1')) {
            $sub1 = request('sub1');
            $q->where('sub1', 'LIKE', "%{$sub1}%");
        }
        if (request('sub2')) {
            $sub2 = request('sub2');
            $q->where('sub2', 'LIKE', "%{$sub2}%");
        }
        if (request('currency_id')) {
            $currency_id = request('currency_id');
            $q->where('currency_id', $currency_id);
        }

        return $q;
    }

    public static function generate_account_number($baseAccountNumber)
    {
        $parts = explode('-', $baseAccountNumber);
        $prefix = $parts[0] . '-' . $parts[1];

        $latestAccount = Account::where('account_number', 'like', $prefix . '-%')
            ->orderBy('account_number', 'desc')
            ->first();

        if ($latestAccount) {
            $latestNumericPart = explode('-', $latestAccount->account_number)[2];
            $suffix = intval($latestNumericPart) + 1;
        } else {
            $suffix = 1;
        }

        $newAccountNumber = $prefix . '-' . str_pad($suffix, 6, '0', STR_PAD_LEFT);

        return $newAccountNumber;
    }
}
