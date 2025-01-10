<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shipment extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function items()
    {
        return $this->hasMany(ShipmentItem::class);
    }

    // Permissions
    public function can_delete()
    {
        return true;
    }

    // Filter
    public function scopeFilter($q)
    {
        if (request('shipment_number')) {
            $shipment_number = request('shipment_number');
            $q->where('shipment_number', 'LIKE', "%{$shipment_number}%");
        }
        if (request('client_id')) {
            $client_id = request('client_id');
            $q->where('client_id', $client_id);
        }
        if (request('mode')) {
            $mode = request('mode');
            $q->where('mode', $mode);
        }
        if (request('departure')) {
            $departure = request('departure');
            $q->where('departure', $departure);
        }
        if (request('arrival')) {
            $arrival = request('arrival');
            $q->where('arrival', $arrival);
        }
        if (request('commodity')) {
            $commodity = request('commodity');
            $q->where('commodity', 'LIKE', "%{$commodity}%");
        }
        if (request('notes')) {
            $notes = request('notes');
            $q->where('notes', 'LIKE', "%{$notes}%");
        }
        if (request('shipping_date')) {
            $shipping_date = request('shipping_date');
            $q->where('shipping_date', $shipping_date);
        }
        if (request('delivery_date')) {
            $delivery_date = request('delivery_date');
            $q->where('delivery_date', $delivery_date);
        }
        if (request('status')) {
            $status = request('status');
            $q->where('status', $status);
        }

        return $q;
    }
}
