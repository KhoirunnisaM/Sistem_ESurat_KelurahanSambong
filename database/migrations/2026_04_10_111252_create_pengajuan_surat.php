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
       Schema::create('pengajuan_surat', function (Blueprint $table) {
    $table->id();
    $table->foreignId('warga_id')->constrained('warga')->cascadeOnDelete();
    $table->string('jenis_surat');
    $table->string('nomor_surat')->nullable();
    $table->dateTime('tanggal_pengajuan');
    $table->dateTime('tanggal_proses')->nullable();
    $table->dateTime('tanggal_selesai')->nullable();
    $table->enum('status', ['diajukan','diproses','ditolak','selesai'])->default('diajukan');
    $table->text('alasan_penolakan')->nullable();
    $table->string('file_hasil')->nullable();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_surat');
    }
};
