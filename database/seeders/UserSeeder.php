<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Akun Administrator
        DB::table('users')->updateOrInsert(
            ['username' => 'admin'],
            [
                'nama_lengkap' => 'Administrator Desa',
                'username'     => 'admin',
                'password'     => Hash::make('password123'),
                'role'         => 'admin',
            ]
        );

        // Akun Bendahara
        DB::table('users')->updateOrInsert(
            ['username' => 'bendahara'],
            [
                'nama_lengkap' => 'Bendahara Desa',
                'username'     => 'bendahara',
                'password'     => Hash::make('password123'),
                'role'         => 'bendahara',
            ]
        );
    }
}
