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
     * - admin@pens.ac.id    / password  → role: admin
     * - petugas1@pens.ac.id / password  → role: petugas
     * - petugas2@pens.ac.id / password  → role: petugas
     */
    public function run(): void
    {
        // Admin
        User::updateOrCreate(
            ['email' => 'admin@pens.ac.id'],
            [
                'name'     => 'Bambang Sutrisno',
                'password' => Hash::make('password'),
                'role'     => 'admin',
            ]
        );

        // Petugas 1
        User::updateOrCreate(
            ['email' => 'petugas1@pens.ac.id'],
            [
                'name'     => 'Siti Rahmawati',
                'password' => Hash::make('password'),
                'role'     => 'petugas',
            ]
        );

        // Petugas 2
        User::updateOrCreate(
            ['email' => 'petugas2@pens.ac.id'],
            [
                'name'     => 'Ahmad Fauzi',
                'password' => Hash::make('password'),
                'role'     => 'petugas',
            ]
        );
    }
}
