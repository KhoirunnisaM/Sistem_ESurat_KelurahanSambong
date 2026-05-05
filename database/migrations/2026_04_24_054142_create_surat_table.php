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
        Schema::create('surat', function (Blueprint $table) {
   
    $table->id();
    $table->foreignId('citizen_id')->constrained('warga')->onDelete('cascade');
    $table->string('jenis_surat'); // SKCK, Domisili Usaha, dll
    
    // Form Umum
    $table->text('keperluan')->nullable();
    $table->text('keterangan')->nullable();

    // Form Khusus Domisili Usaha
    $table->string('nama_lembaga')->nullable();
    $table->string('penanggung_jawab')->nullable();
    $table->string('jabatan_penanggung_jawab')->nullable();
    $table->text('alamat_lembaga')->nullable();

    // File Upload
    $table->string('scan_pengantar_rt');
    $table->string('scan_ktp_kk');

    // Data dari Admin saat Proses
    $table->string('nomor_surat')->nullable();
    $table->date('tanggal_surat_ttd')->nullable();
    $table->foreignId('officer_id')->nullable()->constrained('pegawai');

    // Status
    $table->enum('status', ['Diajukan', 'Diproses', 'Ditolak', 'Selesai', 'Dibatalkan'])->default('Diajukan');
    $table->text('alasan_ditolak')->nullable();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat');
    }
};
