<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jenis_bansos', function (Blueprint $table) {
            // Menambahkan kolom id_periode ke tabel jenis_bansos
            $table->unsignedBigInteger('id_periode')->nullable()->after('id');
            $table->foreign('id_periode')->references('id')->on('periode_bansos')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('jenis_bansos', function (Blueprint $table) {
            $table->dropForeign(['id_periode']);
            $table->dropColumn('id_periode');
        });
    }
};