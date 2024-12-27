<?php

namespace Database\Seeders;

use App\Models\SearchRoute;
use Illuminate\Database\Seeder;

class SearchRouteSeeder extends Seeder
{
    public function run(): void
    {
        $csvFile = fopen(base_path("database/data/SearchRoutes.csv"), "r");

        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            SearchRoute::create([
                "name" => $data['0'],
                "link" => $data['1'],
                "icon" => $data['2'],
            ]);
        }

        fclose($csvFile);
    }
}
