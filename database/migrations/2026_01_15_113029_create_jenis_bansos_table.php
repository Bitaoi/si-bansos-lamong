<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::create('jenis_bansos', function (Blueprint $table) {
        $table->id();
        // 1. Identitas
        $table->string('nama_bansos'); 
        $table->string('kode_bansos', 10)->nullable(); // Baru (Contoh: PKH)
        $table->string('sumber_dana'); // Pusat/Provinsi/Kab/Desa
        $table->text('deskripsi')->nullable(); // Baru

        // 2. Kriteria
        $table->text('kriteria_penerima'); 
        $table->boolean('syarat_dtks')->default(false); // Baru (Wajib DTKS?)
        $table->bigInteger('batas_penghasilan')->nullable(); // Baru

        // 3. Logistik
        $table->string('bentuk_bantuan'); // Tunai/Barang
        $table->string('nominal'); // "300.000" atau "10 Kg"
        $table->string('frekuensi'); // Bulanan/Tahunan

        // 4. Admin
        $table->year('tahun_anggaran'); // Baru
        $table->integer('kuota_penerima')->default(0); // Baru
        $table->enum('status', ['Aktif', 'Non-Aktif'])->default('Aktif');
        
        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('jenis_bansos');
    }
};