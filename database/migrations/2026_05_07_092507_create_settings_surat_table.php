<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabel untuk simpan data Kop & Logo secara global
        Schema::create('settings_surat', function (Blueprint $table) {
            $table->id();
            $table->string('logo')->nullable(); // Path gambar logo
            $table->string('instansi_level_1')->default('PEMERINTAH KABUPATEN BATANG');
            $table->string('instansi_level_2')->default('KECAMATAN BATANG');
            $table->string('nama_lembaga')->default('KELURAHAN SAMBONG');
            $table->string('alamat_jalan')->default('Jl. Kyai Sambong Nomor 12');
            $table->string('no_telp')->default('0285 – 392126');
            $table->string('kode_pos')->default('51212');
            $table->timestamps();
        });

        // Menambahkan field kalimat_penutup ke tabel jenis_surat yang sudah ada
        if (Schema::hasTable('jenis_surat')) {
            Schema::table('jenis_surat', function (Blueprint $table) {
                // Digunakan agar tiap jenis surat punya kalimat penutup berbeda (SKCK vs Domisili)
                $table->text('kalimat_penutup')->nullable()->after('judul_cetak');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('settings_surat');
        if (Schema::hasTable('jenis_surat')) {
            Schema::table('jenis_surat', function (Blueprint $table) {
                $table->dropColumn('kalimat_penutup');
            });
        }
    }
};