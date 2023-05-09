<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMutasiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mutasi', function (Blueprint $table) {
            $table->id();
            $table->string('lokasi_lama');
            $table->string('lokasi_baru');
            $table->string('pj_lama');
            $table->string('pj_baru');
            $table->string('tgl_mutasi');
            $table->string('div_lama');
            $table->string('div_baru');
            $table->unsignedBigInteger('idDataAset');
            $table->foreign('idDataAset')->references('id')->on('detail_aset');
            $table->unsignedBigInteger('idBeritaAcara');
            $table->foreign('idBeritaAcara')->references('id')->on('berita_acara');
            // dereng selese
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('_mutasi');
    }
}
