<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('penyalurans', function (Blueprint $table) {
        $table->id('id_penyaluran');
        $table->unsignedBigInteger('id_pengajuan')->unique();
        $table->foreign('id_pengajuan')->references('id')->on('pengajuans')->onDelete('cascade');

        $table->date('tgl_terima');
        $table->string('foto_bukti', 255);
        $table->text('keterangan')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penyalurans');
    }
};
