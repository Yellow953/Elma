<?php

namespace Database\Seeders;

use App\Models\AccountType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AccountTypeSeeder extends Seeder
{
    public function run(): void
    {
        $csvFile = fopen(base_path("database/data/AccountTypes.csv"), "r");

        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            AccountType::create([
                "id" => $data['0'],
                "name" => $data['1'],
                "parent_id" => ($data['2'] == '' ? null : $data['2']),
                "level" => $data['3'],
            ]);
        }

        fclose($csvFile);
    }
}
