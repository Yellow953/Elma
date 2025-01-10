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
        if (request('loading_date')) {
            $loading_date = request('loading_date');
            $q->where('loading_date', $loading_date);
        }
        if (request('vessel_name')) {
            $vessel_name = request('vessel_name');
            $q->where('vessel_name', 'LIKE', "%{$vessel_name}%");
        }
        if (request('vessel_date')) {
            $vessel_date = request('vessel_date');
            $q->where('vessel_date', $vessel_date);
        }
        if (request('booking_number')) {
            $booking_number = request('booking_number');
            $q->where('booking_number', 'LIKE', "%{$booking_number}%");
        }
        if (request('carrier_name')) {
            $carrier_name = request('carrier_name');
            $q->where('carrier_name', 'LIKE', "%{$carrier_name}%");
        }
        if (request('consignee_name')) {
            $consignee_name = request('consignee_name');
            $q->where('consignee_name', 'LIKE', "%{$consignee_name}%");
        }
        if (request('consignee_country')) {
            $consignee_country = request('consignee_country');
            $q->where('consignee_country', 'LIKE', "%{$consignee_country}%");
        }

        return $q;
    }
}
