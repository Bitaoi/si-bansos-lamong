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
        Schema::create('survei_ekonomis', function (Blueprint $table) {
        $table->id();
        $table->foreignId('pengajuan_id')->constrained('pengajuans')->onDelete('cascade');
        $table->string('jenis_lantai');
        $table->string('jenis_dinding');
        $table->string('sumber_air');
        $table->string('daya_listrik');
        $table->string('kepemilikan_aset');
        $table->integer('total_skor');
        $table->integer('desil_hasil');
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survei_ekonomis');
    }
};
