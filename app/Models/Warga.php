<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warga extends Model
{
    use HasFactory;

    protected $table = 'warga';

    protected $fillable = [
        'nama_lengkap',
        'nik',
        'no_kk',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat_lengkap',
        'rt',
        'rw',
        'agama',
        'jenis_kelamin',
        'status_perkawinan',
        'pekerjaan',
        'status_akun', // Tambahkan ini agar bisa menyimpan status
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'status_akun' => 'boolean',
    ];
}