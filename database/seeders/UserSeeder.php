<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
               // Admin
        DB::table('users')->insert([
            'username' => 'admin',
            'email' => 'admin@example.com',
            'role' => 'admin',
            'password' => Hash::make('admin123'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // User
        DB::table('users')->insert([
            'username' => 'owner',
            'email' => 'owner@example.com',
            'role' => 'owner',
            'password' => Hash::make('owner123'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
