<?php

namespace Database\Seeders;

use App\Models\PO;
use App\Models\POItem;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class POSeeder extends Seeder
{
    public function run(): void
    {
        $pos = [
            ['name' => 'M-PO-2024-1', 'description' => 'test main', 'date' => Carbon::today(), 'supplier_id' => 1],
            ['name' => 'S-PO-2024-1', 'description' => 'test secondary', 'date' => Carbon::today(), 'supplier_id' => 1]
        ];

        $items = [
            ['po_id' => 1, 'item_id' => 1, 'quantity' => 10],
            ['po_id' => 1, 'item_id' => 3, 'quantity' => 10],
            ['po_id' => 2, 'item_id' => 2, 'quantity' => 10],
            ['po_id' => 2, 'item_id' => 4, 'quantity' => 10]
        ];

        foreach ($pos as $po) {
            PO::create($po);
        }

        foreach ($items as $item) {
            POItem::create($item);
        }
    }
}
