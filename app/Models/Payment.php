<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    // Permissions
    public function can_delete()
    {
        return true;
    }

    // Filter
    public function scopeFilter($q)
    {
        if (request('payment_number')) {
            $payment_number = request('payment_number');
            $q->where('payment_number', 'LIKE', "%{$payment_number}%");
        }
        if (request('description')) {
            $description = request('description');
            $q->where('description', 'LIKE', "%{$description}%");
        }
        if (request('supplier_id')) {
            $supplier_id = request('supplier_id');
            $q->where('supplier_id', $supplier_id);
        }
        if (request('client_id')) {
            $client_id = request('client_id');
            $q->where('client_id', $client_id);
        }
        if (request('currency_id')) {
            $currency_id = request('currency_id');
            $q->where('currency_id', $currency_id);
        }
        if (request('date')) {
            $date = request('date');
            $q->where('date', $date);
        }

        return $q;
    }

    public static function generate_number()
    {
        $year = date('Y');
        $lastPayment = Payment::whereYear('created_at', $year)->whereIn('type', 'cash receipt')->latest()->first();

        if ($lastPayment) {
            $lastNumber = explode('-', $lastPayment->payment_number)[2];
            return 'PT-' . $year . '-' . ($lastNumber + 1);
        } else {
            return 'PT-' . $year . '-1';
        }
    }

    public static function generate_return_number()
    {
        $year = date('Y');
        $lastPayment = Payment::whereYear('created_at', $year)->where('type', 'return cash receipt')->latest()->first();

        if ($lastPayment) {
            $lastNumber = explode('-', $lastPayment->payment_number)[3];
            return 'RT-PT-' . $year . '-' . ($lastNumber + 1);
        } else {
            return 'RT-PT-' . $year . '-1';
        }
    }
}
