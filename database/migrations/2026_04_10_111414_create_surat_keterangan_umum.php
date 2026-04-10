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
Schema::create('surat_keterangan_umum', function (Blueprint $table) {
    $table->id();
    $table->foreignId('pengajuan_id')->constrained('pengajuan_surat')->cascadeOnDelete();

    $table->text('keterangan');

    // dokumen
    $table->string('file_ktp')->nullable();
    $table->string('file_kk');
    $table->string('file_surat_rt');

    $table->timestamps();
});    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_keterangan_umum');
    }
};
