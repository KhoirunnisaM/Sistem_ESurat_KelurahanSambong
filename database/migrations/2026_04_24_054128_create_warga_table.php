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
        Schema::create('warga', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap');
            $table->char('nik', 16)->unique();
            $table->char('no_kk', 16);
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->text('alamat_lengkap');
            $table->string('rt', 3);
            $table->string('rw', 3);
            $table->string('kelurahan')->default('Sambong');
            $table->string('kecamatan')->default('Batang');
            $table->string('kabupaten')->default('Batang');
            $table->string('agama');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->string('status_perkawinan');
            $table->string('pekerjaan');
            $table->boolean('status_akun')->default(true);
            $table->timestamps();
});        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warga');
    }
};
