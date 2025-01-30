<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        $suppliers = [
            [
                'name' => 'Supplier 1',
                'phone' => '123456789',
                'address' => 'test address',
                'email' => 'supplier1@gmail.com',
                'tax_id' => 2,
                'account_id' => 390,
                'payable_account_id' => 134,
                'currency_id' => 1,
                'vat_number' => 123,
            ],
            [
                'name' => 'DHL',
                'phone' => '+4915204820649',
                'address' => 'testing',
                'email' => 'support@dhl.de',
                'tax_id' => 2,
                'account_id' => 392,
                'payable_account_id' => 134,
                'currency_id' => 1,
                'vat_number' => 125,
            ],
            [
                'name' => 'CMA',
                'phone' => '+4915204820649',
                'address' => 'beirut',
                'email' => 'support@cma.lb',
                'tax_id' => 2,
                'account_id' => 393,
                'payable_account_id' => 134,
                'currency_id' => 1,
                'vat_number' => 12231325,
            ],
            [
                'name' => 'Maersk',
                'phone' => '+4915204820649',
                'address' => 'beirut',
                'email' => 'support@maersk.lb',
                'tax_id' => 2,
                'account_id' => 394,
                'payable_account_id' => 134,
                'currency_id' => 1,
                'vat_number' => 1297325,
            ]
        ];

        foreach ($suppliers as $supplier) {
            Supplier::create($supplier);
        }
    }
}
