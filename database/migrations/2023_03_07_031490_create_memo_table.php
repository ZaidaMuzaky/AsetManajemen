<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('memo', function (Blueprint $table) {
            $table->id();
            $table->string('kode_memo');
            $table->date('tgl_memo');
            $table->string('perihal');
            $table->string('deskripsi');
            $table->unsignedBigInteger('pengirim');
            $table->foreign('pengirim')->references('id_user')->on('users');
            $table->unsignedBigInteger('penerima');
            $table->foreign('penerima')->references('id')->on('penanggung_jawab');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('memo');
    }
}
