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
                'country' => 'Lebanon',
                'email' => 'supplier1@gmail.com',
                'contact_person' => 'Ali Hamada',
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
                'country' => 'Germany',
                'email' => 'support@dhl.de',
                'contact_person' => 'Hans Meier',
                'tax_id' => 2,
                'account_id' => 392,
                'payable_account_id' => 134,
                'currency_id' => 1,
                'vat_number' => 125,
            ]
        ];

        foreach ($suppliers as $supplier) {
            Supplier::create($supplier);
        }
    }
}
