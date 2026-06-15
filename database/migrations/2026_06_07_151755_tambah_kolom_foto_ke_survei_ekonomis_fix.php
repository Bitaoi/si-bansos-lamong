<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('survei_ekonomis', function (Blueprint $table) {
            // Pengecekan dipecah satu per satu agar jika salah satu hilang, tetap bisa dibuat
            if (!Schema::hasColumn('survei_ekonomis', 'foto_lantai')) { $table->text('foto_lantai')->nullable(); }
            if (!Schema::hasColumn('survei_ekonomis', 'foto_dinding')) { $table->text('foto_dinding')->nullable(); }
            if (!Schema::hasColumn('survei_ekonomis', 'foto_wc_air')) { $table->text('foto_wc_air')->nullable(); }
            if (!Schema::hasColumn('survei_ekonomis', 'foto_sumber_air')) { $table->text('foto_sumber_air')->nullable(); }
            if (!Schema::hasColumn('survei_ekonomis', 'foto_listrik')) { $table->text('foto_listrik')->nullable(); }
            if (!Schema::hasColumn('survei_ekonomis', 'foto_kendaraan')) { $table->text('foto_kendaraan')->nullable(); }
            if (!Schema::hasColumn('survei_ekonomis', 'foto_elektronik')) { $table->text('foto_elektronik')->nullable(); }
            if (!Schema::hasColumn('survei_ekonomis', 'foto_ternak')) { $table->text('foto_ternak')->nullable(); }
        });
    }

    public function down()
    {
        Schema::table('survei_ekonomis', function (Blueprint $table) {
            // Cek terlebih dahulu sebelum di-drop agar tidak error saat rollback
            $columns = ['foto_lantai', 'foto_dinding', 'foto_wc_air', 'foto_sumber_air', 'foto_listrik', 'foto_kendaraan', 'foto_elektronik', 'foto_ternak'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('survei_ekonomis', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};