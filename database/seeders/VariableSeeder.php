<?php

namespace Database\Seeders;

use App\Models\Variable;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        ];

        foreach ($variables as $variable) {
            Variable::create($variable);
        }
    }
}
