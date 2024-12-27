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

    public function journal_vouchers()
    {
        return $this->hasMany(JournalVoucher::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class)->where('hidden', false);
    }

    public function pos()
    {
        return $this->hasMany(PO::class);
    }

    // Permissions
    public function can_delete()
    {
        return $this->users->count() == 0 && $this->accounts->count() == 0 && $this->suppliers->count() == 0 && $this->clients->count() == 0 && $this->journal_vouchers->count() == 0 && $this->transactions->count() == 0 && $this->pos->count() == 0;
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
