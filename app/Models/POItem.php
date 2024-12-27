<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class POItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function po()
    {
        return $this->belongsTo(PO::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
