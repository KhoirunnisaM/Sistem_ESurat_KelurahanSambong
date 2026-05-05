<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Surat extends Model
{
    protected $table = 'surat';
    protected $guarded = [];
    

    // Surat ini milik satu warga
    public function warga()
    {
        return $this->belongsTo(Warga::class, 'citizen_id');
    }

    // Surat ini ditandatangani oleh satu pegawai
    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'officer_id');
    }
}
