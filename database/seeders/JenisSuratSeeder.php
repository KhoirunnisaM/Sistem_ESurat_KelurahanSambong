<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JenisSuratSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
    $data = [
        ['nama_jenis' => 'Surat Keterangan Umum', 'judul_cetak' => 'SURAT KETERANGAN'],
        ['nama_jenis' => 'Surat Keterangan Tidak Mampu', 'judul_cetak' => 'SURAT KETERANGAN TIDAK MAMPU'],
        ['nama_jenis' => 'Surat Keterangan Usaha', 'judul_cetak' => 'SURAT KETERANGAN USAHA'],
        ['nama_jenis' => 'Surat Pengantar SKCK', 'judul_cetak' => 'SURAT PENGANTAR CATATAN KEPOLISIAN'],
        ['nama_jenis' => 'Surat Pengantar Umum', 'judul_cetak' => 'SURAT PENGANTAR'],
        ['nama_jenis' => 'Surat Keterangan Domisili Usaha', 'judul_cetak' => 'SURAT KETERANGAN DOMISILI USAHA'],
        ['nama_jenis' => 'Surat keterangan Domisili Tempat Tinggal', 'judul_cetak' => 'SURAT KETERANGAN DOMISILI TEMPAT TINGGAL'],
    ];

    foreach ($data as $d) {
        \App\Models\JenisSurat::updateOrCreate(['nama_jenis' => $d['nama_jenis']], $d);
    }
}

}
