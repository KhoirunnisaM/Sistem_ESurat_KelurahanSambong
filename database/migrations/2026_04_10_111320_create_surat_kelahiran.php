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
        Schema::create('surat_kelahiran', function (Blueprint $table) {
    $table->id();
    $table->foreignId('pengajuan_id')->constrained('pengajuan_surat')->cascadeOnDelete();

    $table->string('nama_anak');
    $table->string('tempat_lahir');
    $table->date('tanggal_lahir');
    $table->string('jenis_kelamin');
    $table->integer('anak_ke');
    $table->string('nama_ayah');
    $table->string('nama_ibu');
    $table->string('agama');
    $table->text('alamat');

    $table->string('file_kk');
    $table->string('file_ktp_ortu')->nullable();
    $table->string('file_surat_rt');
    $table->string('file_surat_lahir');

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_kelahiran');
    }
};
