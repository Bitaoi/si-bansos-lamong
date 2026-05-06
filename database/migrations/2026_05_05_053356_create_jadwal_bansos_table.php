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
        Schema::create('jadwal_bansos', function (Blueprint $table) {
            $table->id();
            $table->string('nama_tahapan');
            $table->text('deskripsi');
            $table->integer('hari_mulai');
            $table->integer('hari_selesai');
            $table->string('warna_bg');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_bansos');
    }
};
