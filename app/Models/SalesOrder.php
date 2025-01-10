<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalesOrder extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function shipment()
    {
        return $this->belongsTo(Shipment::class);
    }

    public function items()
    {
        return $this->hasMany(SalesOrderItem::class, 'sales_order_id');
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class, 'sales_order_id');
    }

    // Permissions
    public function can_delete()
    {
        return $this->invoice == null;
    }

    // Filter
    public function scopeFilter($q)
    {
        if (request('so_number')) {
            $so_number = request('so_number');
            $q->where('so_number', 'LIKE', "%{$so_number}%");
        }
        if (request('client_id')) {
            $client_id = request('client_id');
            $q->where('client_id', $client_id);
        }
        if (request('shipment_id')) {
            $shipment_id = request('shipment_id');
            $q->where('shipment_id', $shipment_id);
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

    public static function generate_so_number()
    {
        $year = date('Y');
        $searchTerm = "SO-" . $year;

        $lastSO = SalesOrder::where("so_number", "LIKE", "%{$searchTerm}%")->get()->last();
        if ($lastSO) {
            $lastNumber = explode('-', $lastSO->so_number)[2];
            return 'SO-' . $year . '-' . ($lastNumber + 1);
        } else {
            return 'SO-' . $year . '-1';
        }
    }
}
