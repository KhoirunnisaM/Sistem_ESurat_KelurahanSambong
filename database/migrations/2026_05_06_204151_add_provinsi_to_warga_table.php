<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('warga', function (Blueprint $table) {
        $table->string('provinsi')->default('Jawa Tengah')->after('kabupaten');
    });
}

public function down()
{
    Schema::table('warga', function (Blueprint $table) {
        $table->dropColumn(['provinsi']);
    });
}
};
