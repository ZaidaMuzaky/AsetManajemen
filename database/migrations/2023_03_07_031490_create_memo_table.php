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
            $table->foreign('pengirim')->references('id')->on('users');
            $table->unsignedBigInteger('Penerima');
            $table->foreign('Penerima')->references('id')->on('users');
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
