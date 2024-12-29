<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function revenue_account()
    {
        return $this->belongsTo(Account::class, 'revenue_account_id');
    }

    public function receipt_items()
    {
        return $this->hasMany(ReceiptItem::class);
    }

    public function invoice_items()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    // Filter
    public function scopeFilter($q)
    {
        if (request('search')) {
            $search = request('search');
            $q->where('itemcode', 'LIKE', "%{$search}%")->orWhere('description', 'LIKE', "%{$search}%");
        }
        if (request('name')) {
            $name = request('name');
            $q->where('name', 'LIKE', "%{$name}%");
        }
        if (request('itemcode')) {
            $itemcode = request('itemcode');
            $q->where('itemcode', 'LIKE', "%{$itemcode}%");
        }
        if (request('description')) {
            $description = request('description');
            $q->where('description', 'LIKE', "%{$description}%");
        }
        if (request('type')) {
            $type = request('type');
            $q->where('type', 'LIKE', "%{$type}%");
        }
        if (request('revenue_account_id')) {
            $revenue_account_id = request('revenue_account_id');
            $q->where('revenue_account_id', $revenue_account_id);
        }

        return $q;
    }
}
