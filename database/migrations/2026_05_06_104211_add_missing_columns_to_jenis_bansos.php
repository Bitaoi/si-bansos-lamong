<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jenis_bansos', function (Blueprint $table) {
            // Cek apakah kolom belum ada sebelum menambahkannya
            if (!Schema::hasColumn('jenis_bansos', 'sumber_dana')) {
                $table->string('sumber_dana')->nullable()->after('kode_bansos');
            }
            if (!Schema::hasColumn('jenis_bansos', 'deskripsi_bantuan')) {
                $table->text('deskripsi_bantuan')->nullable()->after('kode_bansos');
            }
            if (!Schema::hasColumn('jenis_bansos', 'bentuk_penyerahan')) {
                $table->string('bentuk_penyerahan')->nullable()->after('kode_bansos');
            }
            if (!Schema::hasColumn('jenis_bansos', 'kriteria_lainnya')) {
                $table->text('kriteria_lainnya')->nullable()->after('kriteria_desil');
            }
        });
    }

    public function down(): void
    {
        Schema::table('jenis_bansos', function (Blueprint $table) {
            // Hapus kolom hanya jika kolom tersebut ada
            if (Schema::hasColumn('jenis_bansos', 'sumber_dana')) {
                $table->dropColumn('sumber_dana');
            }
            if (Schema::hasColumn('jenis_bansos', 'deskripsi_bantuan')) {
                $table->dropColumn('deskripsi_bantuan');
            }
            if (Schema::hasColumn('jenis_bansos', 'bentuk_penyerahan')) {
                $table->dropColumn('bentuk_penyerahan');
            }
            if (Schema::hasColumn('jenis_bansos', 'kriteria_lainnya')) {
                $table->dropColumn('kriteria_lainnya');
            }
        });
    }
};