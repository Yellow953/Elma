<?php

namespace Database\Seeders;

use App\Models\Tax;
use Illuminate\Database\Seeder;

class TaxSeeder extends Seeder
{
    public function run(): void
    {
        $taxes = [
            ['name' => 'Tax Free', 'rate' => 0, 'account_id' => 388],
            ['name' => 'Vat 11%', 'rate' => 11, 'account_id' => 389],
        ];

        foreach ($taxes as $tax) {
            Tax::create($tax);
        }
    }
}
