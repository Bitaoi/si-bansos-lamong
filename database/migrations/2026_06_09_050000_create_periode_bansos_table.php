<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('periode_bansos', function (Blueprint $table) {
            $table->id();
            $table->string('nama_periode'); // Contoh: "Tahap 1 - 2026"

            $table->date('tanggal_mulai');
            $table->date('tanggal_akhir');
            
            $table->enum('status', ['Aktif', 'Tutup'])->default('Tutup');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('periode_bansos');
  
        }
};