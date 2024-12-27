<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CDNoteItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function cdnote()
    {
        return $this->belongsTo(CDNote::class);
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}
