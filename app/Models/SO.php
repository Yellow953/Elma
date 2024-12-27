<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SO extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function so_items()
    {
        return $this->hasMany(SOItem::class, 'so_id');
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class, 'so_id');
    }

    // Permissions
    public function can_delete()
    {
        return $this->so_items->count() == 0 && $this->invoice == null;
    }

    // Filter
    public function scopeFilter($q)
    {
        if (request('name')) {
            $name = request('name');
            $q->where('name', 'LIKE', "%{$name}%");
        }
        if (request('description')) {
            $description = request('description');
            $q->where('description', 'LIKE', "%{$description}%");
        }
        if (request('date')) {
            $date = request('date');
            $q->where('date', $date);
        }

        return $q;
    }

    public static function generate_name()
    {
        $year = date('Y');
        $searchTerm = "SO-" . $year;

        $lastSO = SO::where("name", "LIKE", "%{$searchTerm}%")->get()->last();
        if ($lastSO) {
            $lastNumber = explode('-', $lastSO->name)[3];
            return 'SO-' . $year . '-' . ($lastNumber + 1);
        } else {
            return 'SO-' . $year . '-1';
        }
    }
}
