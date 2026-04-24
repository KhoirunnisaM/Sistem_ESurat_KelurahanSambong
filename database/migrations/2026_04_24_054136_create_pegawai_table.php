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
        Schema::create('pegawai', function (Blueprint $table) {
            $table->id();
            $table->enum('kategori', ['Pegawai', 'Staff']);
            $table->string('nama_lengkap');
            $table->string('nip', 30)->nullable(); // Untuk Pegawai
            $table->string('nipppk', 30)->nullable(); // Untuk Staff
            $table->string('jabatan');
            $table->timestamps();
});        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawai');
    }
};
