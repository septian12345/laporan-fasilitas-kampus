<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\KategoriFasilitas;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Kategori fasilitas
        $kategoris = ['Elektronik', 'Furnitur', 'Sanitasi', 'Jaringan / Internet', 'Bangunan'];
        foreach ($kategoris as $nama) {
            KategoriFasilitas::firstOrCreate(['nama_kategori' => $nama]);
        }

        // Akun admin default
        User::firstOrCreate(
            ['email' => 'admin@kampus.ac.id'],
            [
                'name' => 'Admin Kampus',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );

        // Akun petugas default
        User::firstOrCreate(
            ['email' => 'petugas@kampus.ac.id'],
            [
                'name' => 'Petugas Sarana',
                'password' => Hash::make('petugas123'),
                'role' => 'petugas',
            ]
        );
    }
}