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
        ];

        foreach ($variables as $variable) {
            Variable::create($variable);
        }
    }
}
