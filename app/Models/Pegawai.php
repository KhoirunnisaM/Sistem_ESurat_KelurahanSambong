<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pegawai extends Model
{
    use SoftDeletes;
    protected $table = 'pegawai';
    protected $fillable = [
        'nama_lengkap',
        'kategori',
        'nip',
        'nipppk',
        'jabatan'
    ];
}

