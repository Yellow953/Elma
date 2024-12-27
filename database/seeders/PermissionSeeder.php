<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $csvFile = fopen(base_path("database/data/Permissions.csv"), "r");

        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            Permission::firstOrCreate(['name' => $data[0]]);
        }

        fclose($csvFile);

        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $staffRole = Role::firstOrCreate(['name' => 'staff']);

        $adminRole->givePermissionTo(Permission::all());

        $staffPermissions = [
            'users.read',
            'clients.read',
            'suppliers.read',
        ];
        $staffRole->syncPermissions($staffPermissions);

        User::find(1)->assignRole($adminRole);
        User::find(2)->assignRole($staffRole);
    }
}
