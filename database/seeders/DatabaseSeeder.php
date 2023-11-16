<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(100)->create();

        $user = \App\Models\User::factory()->create([
            'name' => 'shubham bramhane',
            'email' => 'test@example.com',
            'password' => bcrypt('123456789'),
            'role_id' => 1,
        ]);
    }
}
