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
        Schema::table('jenis_bansos', function (Blueprint $table) {
            // Tambah kolom baru
            $table->json('kriteria_desil')->nullable()->after('tahun_anggaran');
            $table->string('deskripsi_kuota')->nullable()->after('kuota');
            
            // Hapus tombol switch DTKS yang lama
            if (Schema::hasColumn('jenis_bansos', 'wajib_dtks')) {
                $table->dropColumn('wajib_dtks');
            }
        });
    }

    public function down(): void
    {
        Schema::table('jenis_bansos', function (Blueprint $table) {
            $table->dropColumn(['kriteria_desil', 'deskripsi_kuota']);
            $table->boolean('wajib_dtks')->default(false);
        });
    }
};
