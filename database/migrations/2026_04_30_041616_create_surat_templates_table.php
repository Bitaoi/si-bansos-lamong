<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('surat_templates', function (Blueprint $table) {
            $table->id();
            $table->string('judul_surat'); // Misal: Surat Keterangan / Surat Undangan
            $table->enum('tipe', ['Undangan', 'Keterangan']);
            $table->longText('konten_html'); // Isi format suratnya
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surat_templates');
    }
};