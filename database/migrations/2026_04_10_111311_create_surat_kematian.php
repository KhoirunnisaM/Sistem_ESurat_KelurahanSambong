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
       Schema::create('surat_kematian', function (Blueprint $table) {
    $table->id();
    $table->foreignId('pengajuan_id')->constrained('pengajuan_surat')->cascadeOnDelete();

    $table->string('nama_almarhum');
    $table->string('ttl');
    $table->string('jenis_kelamin');
    $table->string('pekerjaan');
    $table->string('agama');
    $table->text('alamat');

    $table->string('hari_kematian');
    $table->date('tanggal_kematian');
    $table->time('jam_kematian');
    $table->string('sebab_kematian');
    $table->string('tempat_kematian');

    $table->string('file_kk');
    $table->string('file_ktp')->nullable();
    $table->string('file_surat_rt');
    $table->string('file_surat_rs')->nullable();

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_kematian');
    }
};
