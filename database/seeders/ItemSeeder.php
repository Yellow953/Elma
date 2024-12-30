<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            // Sea Freight
            ['name' => 'Sea Freight - 20DRY', 'description' => 'Sea freight for a 20DRY container', 'unit_price' => 1000, 'unit' => 'per container', 'type' => 'item'],
            ['name' => 'Sea Freight - 40HC', 'description' => 'Sea freight for a 40HC container', 'unit_price' => 1500, 'unit' => 'per container', 'type' => 'item'],
            ['name' => 'Sea Freight - 20T', 'description' => 'Sea freight for a 20T container', 'unit_price' => 1200, 'unit' => 'per container', 'type' => 'item'],
            ['name' => 'Sea Freight - 40T', 'description' => 'Sea freight for a 40T container', 'unit_price' => 1800, 'unit' => 'per container', 'type' => 'item'],
            ['name' => 'Sea Freight - 20 Reefer', 'description' => 'Sea freight for a 20 Reefer container', 'unit_price' => 2000, 'unit' => 'per container', 'type' => 'item'],
            ['name' => 'Sea Freight - 40 Reefer', 'description' => 'Sea freight for a 40 Reefer container', 'unit_price' => 2500, 'unit' => 'per container', 'type' => 'item'],

            // Air Freight
            ['name' => 'Air Freight - 20DRY', 'description' => 'Air freight for a 20DRY container', 'unit_price' => 3000, 'unit' => 'per container', 'type' => 'item'],
            ['name' => 'Air Freight - 40HC', 'description' => 'Air freight for a 40HC container', 'unit_price' => 4500, 'unit' => 'per container', 'type' => 'item'],
            ['name' => 'Air Freight - 20T', 'description' => 'Air freight for a 20T container', 'unit_price' => 3500, 'unit' => 'per container', 'type' => 'item'],
            ['name' => 'Air Freight - 40T', 'description' => 'Air freight for a 40T container', 'unit_price' => 5000, 'unit' => 'per container', 'type' => 'item'],
            ['name' => 'Air Freight - 20 Reefer', 'description' => 'Air freight for a 20 Reefer container', 'unit_price' => 5500, 'unit' => 'per container', 'type' => 'item'],
            ['name' => 'Air Freight - 40 Reefer', 'description' => 'Air freight for a 40 Reefer container', 'unit_price' => 7000, 'unit' => 'per container', 'type' => 'item'],

            // Land Freight
            ['name' => 'Land Freight - 20DRY', 'description' => 'Land freight for a 20DRY container', 'unit_price' => 800, 'unit' => 'per container', 'type' => 'item'],
            ['name' => 'Land Freight - 40HC', 'description' => 'Land freight for a 40HC container', 'unit_price' => 1200, 'unit' => 'per container', 'type' => 'item'],
            ['name' => 'Land Freight - 20T', 'description' => 'Land freight for a 20T container', 'unit_price' => 900, 'unit' => 'per container', 'type' => 'item'],
            ['name' => 'Land Freight - 40T', 'description' => 'Land freight for a 40T container', 'unit_price' => 1300, 'unit' => 'per container', 'type' => 'item'],
            ['name' => 'Land Freight - 20 Reefer', 'description' => 'Land freight for a 20 Reefer container', 'unit_price' => 1600, 'unit' => 'per container', 'type' => 'item'],
            ['name' => 'Land Freight - 40 Reefer', 'description' => 'Land freight for a 40 Reefer container', 'unit_price' => 2000, 'unit' => 'per container', 'type' => 'item'],

            // Other
            ['name' => 'Shipping Fee', 'description' => 'Shipping cost charged by supplier', 'unit_price' => 0, 'unit' => 'flat', 'type' => 'expense'],
            ['name' => 'Customs Fee', 'description' => 'Customs clearance fee', 'unit_price' => 0, 'unit' => 'flat', 'type' => 'expense'],
            ['name' => 'Transporter Fee', 'description' => 'Transportation cost by agent', 'unit_price' => 0, 'unit' => 'flat', 'type' => 'expense'],
        ];

        foreach ($items as $item) {
            Item::create($item);
        }
    }
}
