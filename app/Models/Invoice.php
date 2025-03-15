<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function shipment()
    {
        return $this->belongsTo(Shipment::class);
    }

    public function tax()
    {
        return $this->belongsTo(Tax::class);
    }

    public function sales_order()
    {
        return $this->belongsTo(SalesOrder::class);
    }

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function stats()
    {
        $price = 0;
        $cost = 0;

        foreach ($this->items as $item) {
            if ($item->type == 'expense') {
                $cost += $item->total_price;
            } else {
                $price += $item->total_price;
            }
        }

        return [$cost, $price, $price - $cost];
    }

    // Permissions
    public function can_delete()
    {
        return true;
    }

    // Filter
    public function scopeFilter($q)
    {
        if (request('invoice_number')) {
            $invoice_number = request('invoice_number');
            $q->where('invoice_number', 'LIKE', "%{$invoice_number}%");
        }
        if (request('client_id')) {
            $client_id = request('client_id');
            $q->where('client_id', $client_id);
        }
        if (request('shipment_id')) {
            $shipment_id = request('shipment_id');
            $q->where('shipment_id', $shipment_id);
        }
        if (request('currency_id')) {
            $currency_id = request('currency_id');
            $q->where('currency_id', $currency_id);
        }
        if (request('date')) {
            $date = request('date');
            $q->where('date', $date);
        }
        if (request('tax_id')) {
            $tax_id = request('tax_id');
            $q->where('tax_id', $tax_id);
        }
        if (request('sales_order_id')) {
            $sales_order_id = request('sales_order_id');
            $q->where('sales_order_id', $sales_order_id);
        }

        return $q;
    }

    public static function generate_number()
    {
        $year = date('Y');
        $lastInvoice = Invoice::whereYear('created_at', $year)->where('type', 'invoice')->latest()->first();

        if ($lastInvoice) {
            $lastNumber = explode('-', $lastInvoice->invoice_number)[2];
            return 'INV-' . $year . '-' . ($lastNumber + 1);
        } else {
            return 'INV-' . $year . '-1';
        }
    }

    public static function generate_return_number()
    {
        $year = date('Y');
        $lastInvoice = Invoice::whereYear('created_at', $year)->where('type', 'return')->latest()->first();

        if ($lastInvoice) {
            $lastNumber = explode('-', $lastInvoice->invoice_number)[3];
            return 'RT-INV-' . $year . '-' . ($lastNumber + 1);
        } else {
            return 'RT-INV-' . $year . '-1';
        }
    }
}
