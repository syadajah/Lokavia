<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory()->create([
            'username' => 'admin',
            'email' => 'admin@example.com',
            'role' => 'admin',
            'password' => Hash::make('admin123'),
        ],);
        
        \App\Models\User::factory()->create([
            'username' => 'user',
            'email' => 'user@example.com',
            'role' => 'user',
            'password' => Hash::make('user123'),
        ],);

        // \App\Models\User::factory(10)->create();
    }
}
