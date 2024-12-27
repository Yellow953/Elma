<?php

namespace Database\Seeders;

use App\Models\Account;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AccountSeeder extends Seeder
{
    public function run(): void
    {
        $csvFile = fopen(base_path("database/data/Accounts.csv"), "r");

        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            Account::create([
                "id" => $data['0'],
                "account_number" => $data['1'],
                "account_description" => $data['2'],
                "type" => $data['3'],
                "currency_id" => 1,
            ]);
        }

        fclose($csvFile);
    }
}
