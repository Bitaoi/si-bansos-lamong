<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('survei_ekonomis', function (Blueprint $table) {
            // Kita pakai tipe 'text' agar cukup menampung JSON array path file yang panjang
            if (!Schema::hasColumn('survei_ekonomis', 'foto_lantai')) {
                $table->text('foto_lantai')->nullable();
                $table->text('foto_dinding')->nullable();
                $table->text('foto_wc_air')->nullable();
                $table->text('foto_sumber_air')->nullable();
                $table->text('foto_listrik')->nullable();
                $table->text('foto_kendaraan')->nullable();
                $table->text('foto_elektronik')->nullable();
                $table->text('foto_ternak')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('survei_ekonomis', function (Blueprint $table) {
            $table->dropColumn([
                'foto_lantai', 'foto_dinding', 'foto_wc_air', 'foto_sumber_air', 
                'foto_listrik', 'foto_kendaraan', 'foto_elektronik', 'foto_ternak'
            ]);
        });
    }
};