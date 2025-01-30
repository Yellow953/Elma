<?php

namespace Database\Seeders;

use App\Models\Variable;
use Illuminate\Database\Seeder;

class VariableSeeder extends Seeder
{
    public function run(): void
    {
        $variables = [
            [
                'type' => 'configuration',
                'title' => 'expense_account',
                'value' => '243',
            ],
            [
                'type' => 'configuration',
                'title' => 'revenue_account',
                'value' => '327',
            ],
            [
                'type' => 'configuration',
                'title' => 'receivable_account',
                'value' => '148',
            ],
            [
                'type' => 'configuration',
                'title' => 'payable_account',
                'value' => '134',
            ],
            [
                'type' => 'configuration',
                'title' => 'cash_account',
                'value' => '237',
            ],
            [
                'type' => 'ports',
                'title' => 'Port Of Beirut',
                'value' => 'Port Of Beirut',
            ],
            [
                'type' => 'ports',
                'title' => 'Port Of Dubai',
                'value' => 'Port Of Dubai',
            ],
            [
                'type' => 'ports',
                'title' => 'PORT SAID EAST',
                'value' => 'PORT SAID EAST',
            ],

        ];

        foreach ($variables as $variable) {
            Variable::create($variable);
        }
    }
}
