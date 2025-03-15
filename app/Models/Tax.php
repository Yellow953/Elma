<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function suppliers()
    {
        return $this->hasMany(Supplier::class);
    }

    public function clients()
    {
        return $this->hasMany(Client::class);
    }

    // Permissions
    public function can_delete()
    {
        return $this->suppliers->count() == 0 && $this->clients->count() == 0;
    }

    // Filter
    public function scopeFilter($q)
    {
        if (request('name')) {
            $name = request('name');
            $q->where('name', 'LIKE', "%{$name}%");
        }
        if (request('account_id')) {
            $account_id = request('account_id');
            $q->where('account_id', $account_id);
        }

        return $q;
    }
}
