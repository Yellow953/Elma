<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    public function run()
    {
        $currencies = [
            ['code' => 'USD', 'name' => 'US Dollar', 'symbol' => '$', 'rate' => 1],
            ['code' => 'LBP', 'name' => 'Lebanese Bank Pound', 'symbol' => 'lbp', 'rate' => 95000],
        ];

        foreach ($currencies as $currency) {
            Currency::create($currency);
        }
    }
}
