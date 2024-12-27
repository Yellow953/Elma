<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'admin',
                'email' => 'test@test.com',
                'password' => bcrypt('qwe123'),
                'currency_id' => 1,
            ],
            [
                'name' => 'user',
                'email' => 'user@user.com',
                'password' => bcrypt('qwe123'),
                'currency_id' => 1,
            ]
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
