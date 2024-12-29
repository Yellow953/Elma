<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function purchase_orders()
    {
        return $this->hasMany(PurchaseOrder::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function tax()
    {
        return $this->belongsTo(Tax::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }

    public function payable_account()
    {
        return $this->belongsTo(Account::class, 'payable_account_id');
    }

    // Filter
    public function scopeFilter($q)
    {
        if (request('name')) {
            $name = request('name');
            $q->where('name', 'LIKE', "%{$name}%");
        }
        if (request('address')) {
            $address = request('address');
            $q->where('address', 'LIKE', "%{$address}%");
        }
        if (request('contact_person')) {
            $contact_person = request('contact_person');
            $q->where('contact_person', 'LIKE', "%{$contact_person}%");
        }
        if (request('email')) {
            $email = request('email');
            $q->where('email', 'LIKE', "%{$email}%");
        }
        if (request('vat_number')) {
            $vat_number = request('vat_number');
            $q->where('vat_number', $vat_number);
        }
        if (request('country')) {
            $country = request('country');
            $q->where('country', 'LIKE', "%{$country}%");
        }
        if (request('phone')) {
            $phone = request('phone');
            $q->where('phone', $phone);
        }
        if (request('tax_id')) {
            $tax_id = request('tax_id');
            $q->where('tax_id', $tax_id);
        }
        if (request('currency_id')) {
            $currency_id = request('currency_id');
            $q->where('currency_id', $currency_id);
        }
        if (request('account_id')) {
            $account_id = request('account_id');
            $q->where('account_id', $account_id);
        }
        if (request('payable_account_id')) {
            $payable_account_id = request('payable_account_id');
            $q->where('payable_account_id', $payable_account_id);
        }

        return $q;
    }
}
