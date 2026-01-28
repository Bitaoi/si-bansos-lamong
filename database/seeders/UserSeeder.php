<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Buat Akun Admin Desa
        User::create([
            'username' => 'admin',
            'password' => Hash::make('password'), // Password di-hash demi keamanan
            'role' => 'Admin', // Sesuai Tabel 3.8
            'nama_lengkap' => 'Admin Desa Lamong',
            'wilayah_rt_rw' => null, // Admin tidak terikat wilayah RT
        ]);

        // 2. Buat Akun Ketua RT 01
        User::create([
            'username' => 'rt01',
            'password' => Hash::make('password'),
            'role' => 'RT', // Sesuai Tabel 3.8
            'nama_lengkap' => 'Budi Santoso (Ketua RT 01)',
            'wilayah_rt_rw' => '01/01', // Terikat wilayah RT 01 / RW 01
        ]);
        
        // 3. Buat Akun Ketua RT 02 (Opsional, untuk tes beda user)
        User::create([
            'username' => 'rt02',
            'password' => Hash::make('password'),
            'role' => 'RT',
            'nama_lengkap' => 'Siti Aminah (Ketua RT 02)',
            'wilayah_rt_rw' => '02/01', 
        ]);
    }
}