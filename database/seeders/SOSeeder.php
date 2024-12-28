<?php

namespace Database\Seeders;

use App\Models\SO;
use App\Models\SOItem;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SOSeeder extends Seeder
{
    public function run(): void
    {
        $sos = [
            ['name' => 'SO-2024-1', 'description' => 'test', 'date' => Carbon::today()],
            ['name' => 'SO-2024-1', 'description' => 'test', 'date' => Carbon::today()]
        ];

        $items = [
            ['so_id' => 1, 'item_id' => 1, 'quantity' => 10],
            ['so_id' => 1, 'item_id' => 3, 'quantity' => 10],
            ['so_id' => 2, 'item_id' => 2, 'quantity' => 10],
            ['so_id' => 2, 'item_id' => 4, 'quantity' => 10]
        ];

        foreach ($sos as $so) {
            SO::create($so);
        }

        foreach ($items as $item) {
            SOItem::create($item);
        }
    }
}
