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
        Schema::create('surat_keterangan_usaha', function (Blueprint $table) {
    $table->id();
    $table->foreignId('pengajuan_id')->constrained('pengajuan_surat')->cascadeOnDelete();

    $table->string('nama_usaha');
    $table->string('jenis_usaha');
    $table->text('alamat_usaha');
    $table->string('lama_usaha')->nullable();

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
        Schema::dropIfExists('surat_keterangan_usaha');
    }
};
