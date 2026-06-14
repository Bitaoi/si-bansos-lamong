<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kuota_wilayahs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_bansos');
            $table->unsignedBigInteger('id_periode');
            $table->string('rt', 3);
            $table->string('rw', 3);
            $table->integer('kuota');
            $table->integer('terpakai')->default(0);
            
            $table->foreign('id_bansos')->references('id')->on('jenis_bansos')->onDelete('cascade');
            $table->foreign('id_periode')->references('id')->on('periode_bansos')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kuota_wilayahs');
    }
};