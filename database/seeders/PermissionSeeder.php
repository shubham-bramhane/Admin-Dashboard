<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (modulesList() as $module) {
            Permission::UpdateOrCreate(['name' => $module['slug'].'-view']);
            Permission::UpdateOrCreate(['name' => $module['slug'].'-create']);
            Permission::UpdateOrCreate(['name' => $module['slug'].'-edit']);
            Permission::UpdateOrCreate(['name' => $module['slug'].'-delete']);
            Permission::UpdateOrCreate(['name' => $module['slug'].'-status']);
        }
    }
}
