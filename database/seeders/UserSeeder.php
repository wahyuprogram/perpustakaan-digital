<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Membuat akun Administrator
        User::create([
            'Username' => 'admin',
            'Email' => 'admin@gmail.com',
            'Password' => Hash::make('123456'), // Passwordnya: password123
            'NamaLengkap' => 'Administrator Utama',
            'Alamat' => 'Jl. Pusat Data No. 1',
            'role' => 'administrator',
        ]);

        // 2. Membuat akun Petugas
        User::create([
            'Username' => 'petugas',
            'Email' => 'petugas@gmail.com',
            'Password' => Hash::make('123456'), // Passwordnya: password123
            'NamaLengkap' => 'Petugas Jaga',
            'Alamat' => 'Jl. Rak Buku No. 2',
            'role' => 'petugas',
        ]);
    }
}