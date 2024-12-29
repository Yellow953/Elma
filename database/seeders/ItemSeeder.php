<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'name' => 'Small Package Shipping',
                'description' => 'Shipping services for small packages.',
                'unit_price' => 50.00,
                'unit' => 'per package',
                'revenue_account_id' => 327,
            ],
            [
                'name' => 'Container Shipment',
                'description' => 'Shipping services for containers.',
                'unit_price' => 500.00,
                'unit' => 'per container',
                'revenue_account_id' => 327,
            ],
            [
                'name' => 'Customs Clearance',
                'description' => 'Customs clearance services for shipments.',
                'unit_price' => 100.00,
                'unit' => 'per shipment',
                'revenue_account_id' => 327,
            ],
            [
                'name' => 'Warehousing',
                'description' => 'Storage services for goods in the warehouse.',
                'unit_price' => 200.00,
                'unit' => 'per day',
                'revenue_account_id' => 327,
            ],
            [
                'name' => 'Freight Forwarding',
                'description' => 'Management and coordination of freight shipments.',
                'unit_price' => 150.00,
                'unit' => 'per shipment',
                'revenue_account_id' => 327,
            ],
            [
                'name' => 'Documentation Handling',
                'description' => 'Handling and preparation of shipping documents.',
                'unit_price' => 30.00,
                'unit' => 'per document',
                'revenue_account_id' => 327,
            ],
            [
                'name' => 'Insurance Processing',
                'description' => 'Processing insurance for shipments.',
                'unit_price' => 50.00,
                'unit' => 'per shipment',
                'revenue_account_id' => 327,
            ],
            [
                'name' => 'Port Charges',
                'description' => 'Charges incurred at the port for shipment handling.',
                'unit_price' => 75.00,
                'unit' => 'per shipment',
                'revenue_account_id' => 327,
            ],
            [
                'name' => 'Packaging Services',
                'description' => 'Packing goods securely for transportation.',
                'unit_price' => 25.00,
                'unit' => 'per package',
                'revenue_account_id' => 327,
            ],
            [
                'name' => 'Custom Duties Advance',
                'description' => 'Advancing custom duties on behalf of clients.',
                'unit_price' => 0.00,
                'unit' => 'per shipment',
                'revenue_account_id' => 327,
            ],
        ];

        foreach ($items as $item) {
            Item::create($item);
        }
    }
}
