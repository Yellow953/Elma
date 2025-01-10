<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseOrder extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function shipment()
    {
        return $this->belongsTo(Shipment::class);
    }

    public function items()
    {
        return $this->hasMany(PurchaseOrderItem::class, 'purchase_order_id');
    }

    public function receipt()
    {
        return $this->hasOne(Receipt::class, 'purchase_order_id');
    }

    // Permissions
    public function can_delete()
    {
        return $this->receipt == null;
    }

    // Filter
    public function scopeFilter($q)
    {
        if (request('po_number')) {
            $po_number = request('po_number');
            $q->where('po_number', 'LIKE', "%{$po_number}%");
        }
        if (request('supplier_id')) {
            $supplier_id = request('supplier_id');
            $q->where('supplier_id', $supplier_id);
        }
        if (request('notes')) {
            $notes = request('notes');
            $q->where('notes', 'LIKE', "%{$notes}%");
        }
        if (request('order_date')) {
            $order_date = request('order_date');
            $q->where('order_date', $order_date);
        }
        if (request('due_date')) {
            $due_date = request('due_date');
            $q->where('due_date', $due_date);
        }
        if (request('status')) {
            $status = request('status');
            $q->where('status', $status);
        }

        return $q;
    }

    public static function generate_po_number()
    {
        $year = date('Y');
        $searchTerm = "PO-" . $year;

        $lastPO = PurchaseOrder::where("po_number", "LIKE", "%{$searchTerm}%")->get()->last();
        if ($lastPO) {
            $lastNumber = explode('-', $lastPO->po_number)[2];
            return 'PO-' . $year . '-' . ($lastNumber + 1);
        } else {
            return 'PO-' . $year . '-1';
        }
    }
}
