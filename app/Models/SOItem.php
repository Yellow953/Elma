<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SOItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function so()
    {
        return $this->belongsTo(SO::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
