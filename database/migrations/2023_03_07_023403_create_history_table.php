<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('history', function (Blueprint $table) {
            $table->id();
            $table->string('kode_aset');
            $table->string('nama');
            $table->string('qr')->nullable();
            $table->string('serial_number')->nullable();
            $table->string('kategori_aset');
            $table->year('tahun_perolehan');
            $table->string('asal_perusahaan');
            $table->enum('kondisi', ['Baik', 'RusakRingan', 'RusakBerat'])->default('Baik');
            $table->text('deskripsi_aset');
            $table->string('lokasi', 255);
            $table->unsignedBigInteger('idPenanggungJawab');
            $table->foreign('idPenanggungJawab')->references('id')->on('penanggung_jawab');
            $table->unsignedBigInteger('idDetailBarang');
            $table->foreign('idDetailBarang')->references('id')->on('data_barang');
            $table->unsignedBigInteger('idDataAset');
            $table->foreign('idDataAset')->references('id')->on('detail_aset');
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
        Schema::dropIfExists('history');
    }
}
