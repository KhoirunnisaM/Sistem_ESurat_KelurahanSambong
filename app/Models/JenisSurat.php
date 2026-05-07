<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class JenisSurat extends Model
{
    protected $table = 'jenis_surat'; // Karena nama tabel kita tunggal
    protected $fillable = ['nama_jenis', 'judul_cetak', 'kalimat_penutup'];

    public function surats() {
        return $this->hasMany(Surat::class, 'jenis_surat_id');
    }
}