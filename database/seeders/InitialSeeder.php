<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class InitialSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Akun Admin Pertama
        DB::table('admin')->insert([
            'username' => 'admin',
            'password' => Hash::make('sambong'), // Passwordnya: sambong
            'created_at' => now(),
            'updated_at' => now(),
        ]);

    }
}