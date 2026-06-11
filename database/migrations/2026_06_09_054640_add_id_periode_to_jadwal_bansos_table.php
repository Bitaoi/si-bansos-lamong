<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('jadwal_bansos', function (Blueprint $table) {
            // Menambahkan kolom id_periode sebagai foreign key
            $table->foreignId('id_periode')->nullable()->constrained('periode_bansos')->onDelete('cascade')->after('id');
        });
    }

    public function down()
    {
        Schema::table('jadwal_bansos', function (Blueprint $table) {
            $table->dropForeign(['id_periode']);
            $table->dropColumn('id_periode');
        });
    }
};