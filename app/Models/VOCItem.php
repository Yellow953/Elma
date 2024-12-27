<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VOCItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function voc()
    {
        return $this->belongsTo(VOC::class);
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}
