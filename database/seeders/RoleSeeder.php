<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => 'Super Admin']);
        $admin = Role::create(['name' => 'Admin']);
        $teacher = Role::create(['name' => 'Teacher']);


        $admin->givePermissionTo([
            'users-list',
            'users-create',
            'users-edit',
            'users-delete',
            'users-status',

            'roles-list',
            'roles-create',
            'roles-edit',
            'roles-delete',
            'roles-status',
        ]);

    }
}
