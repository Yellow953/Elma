<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['name' => 'Item 1', 'image' => '/assets/images/profiles/NoItemImage.png', 'quantity' => 100, 'leveling' => 10, 'itemcode' => 'item1', 'description' => 'Item 1 Description', 'type' => 'Non Serialized', 'inventory_account_id' => 128, 'cost_of_sales_account_id' => 240, 'sales_account_id' => 316],
            ['name' => 'Item 1', 'image' => '/assets/images/profiles/NoItemImage.png', 'quantity' => 100, 'leveling' => 10, 'itemcode' => 'item1', 'description' => 'Item 1 Description', 'type' => 'Serialized', 'inventory_account_id' => 128, 'cost_of_sales_account_id' => 240, 'sales_account_id' => 316],
            ['name' => 'Item 2', 'image' => '/assets/images/profiles/NoItemImage.png', 'quantity' => 100, 'leveling' => 10, 'itemcode' => 'item2', 'description' => 'Item 2 Description', 'type' => 'Non Serialized', 'inventory_account_id' => 128, 'cost_of_sales_account_id' => 240, 'sales_account_id' => 316],
            ['name' => 'Item 2', 'image' => '/assets/images/profiles/NoItemImage.png', 'quantity' => 100, 'leveling' => 10, 'itemcode' => 'item2', 'description' => 'Item 2 Description', 'type' => 'Serialized', 'inventory_account_id' => 128, 'cost_of_sales_account_id' => 240, 'sales_account_id' => 316],
        ];

        foreach ($items as $item) {
            Item::create($item);
        }
    }
}
