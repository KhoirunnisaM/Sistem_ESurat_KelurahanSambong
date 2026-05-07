<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingsSuratSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
    \App\Models\SettingSurat::create([
        'logo' => null,
        'instansi_level_1' => 'PEMERINTAH KABUPATEN BATANG',
        'instansi_level_2' => 'KECAMATAN BATANG',
        'nama_lembaga' => 'KELURAHAN SAMBONG',
        'alamat_jalan' => 'Jl. Kyai Sambong Nomor 12',
        'no_telp' => '0285 – 392126',
        'kode_pos' => '51212',
    ]);
}
}
