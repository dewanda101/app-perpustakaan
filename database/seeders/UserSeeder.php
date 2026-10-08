<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Akun login:
     * - admin@pens.ac.id  / password  → role: admin
     * - andi@pens.ac.id   / password  → role: petugas
     * - sari@pens.ac.id   / password  → role: petugas
     */
    public function run(): void
    {
        // Admin
        User::updateOrCreate(
            ['email' => 'admin@pens.ac.id'],
            [
                'name' => 'Budi',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        // Petugas 1
        User::updateOrCreate(
            ['email' => 'andi@pens.ac.id'],
            [
                'name' => 'Andi',
                'password' => Hash::make('password'),
                'role' => 'petugas',
            ]
        );

        // Petugas 2
        User::updateOrCreate(
            ['email' => 'sari@pens.ac.id'],
            [
                'name' => 'Sari',
                'password' => Hash::make('password'),
                'role' => 'petugas',
            ]
        );
    }
}

