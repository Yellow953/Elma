<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentVoucherItem extends Model
{
    protected $guarded = [];

    public function payment_voucher()
    {
        return $this->belongsTo(PaymentVoucher::class);
    }
}
