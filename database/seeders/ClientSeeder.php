<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        Client::create([
            'name' => 'Client 1',
            'phone' => '123456789',
            'address' => 'test address',
            'email' => 'client1@gmail.com',
            'tax_id' => 1,
            'account_id' => 391,
            'receivable_account_id' => 148,
            'currency_id' => 1,
            'vat_number' => 124,
        ]);
    }
}
