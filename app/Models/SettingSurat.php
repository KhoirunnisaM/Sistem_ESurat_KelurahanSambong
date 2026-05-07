<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use HasFactory;

class SettingSurat extends Model
{
    // Nama tabel di database
    protected $table = 'settings_surat';

    // Field yang boleh diisi secara massal
    protected $fillable = [
        'logo',
        'instansi_level_1',
        'instansi_level_2',
        'nama_lembaga',
        'alamat_jalan',
        'no_telp',
        'kode_pos',
    ];
}
