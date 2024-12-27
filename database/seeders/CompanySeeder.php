<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    public function run(): void
    {
        Company::create([
            'name' => 'YellowTech',
            'phone' => '+4915204820649',
            'address' => 'Germany Berlin, werkstrasse 2',
            'email' => 'yellow.tech.953@gmail.com',
            'vat_number' => 2212,
            'website' => 'https://yellowtech.dev',
            'logo' => 'assets/images/logos/logo.png',
            'allow_past_dates' => true,
            'monthly_growth_factor' => 1.1,
        ]);
    }
}
