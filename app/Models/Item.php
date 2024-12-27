<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function inventory_account()
    {
        return $this->belongsTo(Account::class, 'inventory_account_id');
    }

    public function cost_of_sales_account()
    {
        return $this->belongsTo(Account::class, 'cost_of_sales_account_id');
    }

    public function sales_account()
    {
        return $this->belongsTo(Account::class, 'sales_account_id');
    }

    public function po_items()
    {
        return $this->hasMany(POItem::class);
    }

    public function so_items()
    {
        return $this->hasMany(SOItem::class);
    }

    public function receipt_items()
    {
        return $this->hasMany(ReceiptItem::class);
    }

    public function invoice_items()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function secondary_images()
    {
        return $this->hasMany(SecondaryImage::class);
    }

    public function barcodes()
    {
        return $this->hasMany(BarcodeItem::class);
    }

    public function update_unit_cost($unit_cost)
    {
        if ($this->unit_cost == 0) {
            $this->update(['unit_cost' => $unit_cost]);
        } else {
            $old_uc = $this->unit_cost;
            $new_uc = ($old_uc + $unit_cost) / 2;
            $this->update(['unit_cost' => $new_uc]);
        }
    }

    // Permissions
    public function can_delete()
    {
        return auth()->user()->role == "admin" && $this->po_items->count() == 0 && $this->so_items->count() == 0 && $this->receipt_items->count() == 0 && $this->invoice_items->count() == 0 && $this->barcodes->count() == 0;
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
        if (request('warehouse_id')) {
            $warehouse_id = request('warehouse_id');
            $q->where('warehouse_id', $warehouse_id);
        }
        if (request('type')) {
            $type = request('type');
            $q->where('type', 'LIKE', "%{$type}%");
        }
        if (request('inventory_account_id')) {
            $inventory_account_id = request('inventory_account_id');
            $q->where('inventory_account_id', $inventory_account_id);
        }
        if (request('cost_of_sales_account_id')) {
            $cost_of_sales_account_id = request('cost_of_sales_account_id');
            $q->where('cost_of_sales_account_id', $cost_of_sales_account_id);
        }
        if (request('sales_account_id')) {
            $sales_account_id = request('sales_account_id');
            $q->where('sales_account_id', $sales_account_id);
        }

        return $q;
    }
}
