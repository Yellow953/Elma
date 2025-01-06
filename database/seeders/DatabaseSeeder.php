<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            CurrencySeeder::class,
            UserSeeder::class,
            AccountSeeder::class,
            TaxSeeder::class,
            SupplierSeeder::class,
            ClientSeeder::class,
            ItemSeeder::class,
            SearchRouteSeeder::class,
            AccountTypeSeeder::class,
            PermissionSeeder::class,
            VariableSeeder::class,
        ]);
    }
}
