<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Currency extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function accounts()
    {
        return $this->hasMany(Account::class);
    }

    public function suppliers()
    {
        return $this->hasMany(Supplier::class);
    }

    public function clients()
    {
        return $this->hasMany(Client::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class)->where('hidden', false);
    }

    // Filter
    public function scopeFilter($q)
    {
        if (request('code')) {
            $code = request('code');
            $q->where('code', 'LIKE', "%{$code}%");
        }
        if (request('name')) {
            $name = request('name');
            $q->where('name', 'LIKE', "%{$name}%");
        }
        if (request('symbol')) {
            $symbol = request('symbol');
            $q->where('symbol', 'LIKE', "%{$symbol}%");
        }
        if (request('rate')) {
            $rate = request('rate');
            $q->where('rate', $rate);
        }

        return $q;
    }
}
