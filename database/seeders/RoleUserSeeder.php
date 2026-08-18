<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class RoleUserSeeder extends Seeder
{
    public function run(): void
    {
        foreach (Role::cases() as $role) {
            User::firstOrCreate(
                ['email' => $role->value . '@myschool.test'],
                [
                    'name' => $role->label(),
                    'password' => bcrypt('password'),
                    'role' => $role->value,
                ]
            );
        }
    }
}
