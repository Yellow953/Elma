<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shipment extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function due_from()
    {
        return $this->belongsTo(Client::class);
    }

    public function items()
    {
        return $this->hasMany(ShipmentItem::class);
    }

    public function sales_order()
    {
        return $this->hasOne(SalesOrder::class);
    }

    public function purchase_orders()
    {
        return $this->hasMany(PurchaseOrder::class);
    }

    public function shipments()
    {
        return $this->hasMany(Shipment::class);
    }

    // Permissions
    public function can_delete()
    {
        return $this->sales_order == null && $this->purchase_orders == null && $this->shipments == null;
    }

    // Filter
    public function scopeFilter($q)
    {
        if (request('shipment_number')) {
            $shipment_number = request('shipment_number');
            $q->where('shipment_number', 'LIKE', "%{$shipment_number}%");
        }
        if (request('due_from_id')) {
            $due_from_id = request('due_from_id');
            $q->where('due_from_id', $due_from_id);
        }
        if (request('shipper')) {
            $shipper = request('shipper');
            $q->where('shipper', 'LIKE', "%{$shipper}%");
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
        if (request('container_number')) {
            $container_number = request('container_number');
            $q->where('container_number', 'LIKE', "%{$container_number}%");
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

    public static function generate_shipment_number()
    {
        $searchTerm = "EL-";

        $lastShipment = Shipment::where("shipment_number", "LIKE", "%{$searchTerm}%")->get()->last();
        if ($lastShipment) {
            $lastNumber = explode('-', $lastShipment->shipment_number)[1];
            return 'EL-' . ($lastNumber + 1);
        } else {
            return 'EL-1000';
        }
    }
}
