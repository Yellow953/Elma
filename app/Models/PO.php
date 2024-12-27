<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PO extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];


    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function po_items()
    {
        return $this->hasMany(POItem::class, 'po_id');
    }

    public function receipt()
    {
        return $this->hasOne(Receipt::class, 'po_id');
    }

    // Permissions
    public function can_delete()
    {
        return $this->po_items->count() == 0 && $this->receipt == null;
    }

    // Filter
    public function scopeFilter($q)
    {
        if (request('search')) {
            $search = request('search');
            $q->where('name', 'LIKE', "%{$search}%");
        }
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
        if (request('supplier_id')) {
            $supplier_id = request('supplier_id');
            $q->where('supplier_id', $supplier_id);
        }

        return $q;
    }

    public static function generate_name()
    {
        $year = date('Y');
        $searchTerm = "PO-" . $year;

        $lastPO = PO::where("name", "LIKE", "%{$searchTerm}%")->get()->last();
        if ($lastPO) {
            $lastNumber = explode('-', $lastPO->name)[3];
            return 'PO-' . $year . '-' . ($lastNumber + 1);
        } else {
            return 'PO-' . $year . '-1';
        }
    }
}
