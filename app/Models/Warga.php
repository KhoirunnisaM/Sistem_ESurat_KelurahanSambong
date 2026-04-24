<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Warga extends Model
{
    protected $table = 'warga'; // Nama tabel manual
    protected $guarded = [];    // Mengizinkan semua field diisi

    // Satu warga bisa punya banyak surat
    public function surat()
    {
        return $this->hasMany(Surat::class, 'citizen_id');
    }
}
