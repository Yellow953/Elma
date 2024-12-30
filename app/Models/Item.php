<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function purchase_order_items()
    {
        return $this->hasMany(PurchaseOrderItem::class);
    }

    public function sales_order_items()
    {
        return $this->hasMany(SalesOrderItem::class);
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
        if (request('name')) {
            $name = request('name');
            $q->where('name', 'LIKE', "%{$name}%");
        }
        if (request('description')) {
            $description = request('description');
            $q->where('description', 'LIKE', "%{$description}%");
        }
        if (request('type')) {
            $type = request('type');
            $q->where('type', $type);
        }

        return $q;
    }
}
