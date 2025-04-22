<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('AdminIT'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Rizal',
            'email' => 'rizal@gmail.com',
            'password' => Hash::make('123'),
            'role' => 'mahasiswa',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Staff',
            'email' => 'staff@gmail.com',
            'password' => Hash::make('123'),
            'role' => 'dosen',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Adit',
            'email' => 'adit@gmail.com',
            'password' => Hash::make('123'),
            'role' => 'non_mahasiswa',
            'email_verified_at' => now(),
        ]);
    }
}
