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
            POSeeder::class,
            SOSeeder::class,
            CompanySeeder::class,
            SearchRouteSeeder::class,
            AccountTypeSeeder::class,
            PermissionSeeder::class,
        ]);
    }
}
