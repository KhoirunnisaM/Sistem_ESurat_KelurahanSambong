<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('surat_pengantar_izin_keramaian', function (Blueprint $table) {
    $table->id();
    $table->foreignId('pengajuan_id')->constrained('pengajuan_surat')->cascadeOnDelete();

    $table->string('nama_kegiatan');
    $table->text('tujuan_kegiatan');
    $table->date('tanggal_kegiatan');
    $table->time('jam_mulai');
    $table->time('jam_selesai');
    $table->text('lokasi_kegiatan');

    // dokumen
    $table->string('file_ktp');
    $table->string('file_kk');
    $table->string('file_surat_rt');

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_pengantar_izin_keramaian');
    }
};
