<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pegawai', function (Blueprint $blueprint) {
            $blueprint->softDeletes(); // Ini akan membuat kolom 'deleted_at'
        });
    }

    public function down(): void
    {
        Schema::table('pegawai', function (Blueprint $blueprint) {
            $blueprint->dropSoftDeletes(); // Ini untuk menghapus kolom jika rollback
        });
    }
};