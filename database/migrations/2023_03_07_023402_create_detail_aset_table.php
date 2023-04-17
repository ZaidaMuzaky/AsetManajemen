<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailAsetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_aset', function (Blueprint $table) {
            $table->id();
            $table->string('kode_aset');
            $table->string('qr');
            $table->string('serial_number');
            $table->string('kategori_aset');
            $table->string('tahun_perolehan');
            $table->string('asal_perusahaan');
            $table->enum('kondisi', ['Baik', 'RusakRingan', 'RusakBerat'])->default('Baik');
            $table->string('deskripsi_aset');

            $table->unsignedBigInteger('idLokasi');
            $table->foreign('idLokasi')->references('id')->on('lokasi');
            $table->unsignedBigInteger('idPenanggungJawab');
            $table->foreign('idPenanggungJawab')->references('id')->on('penanggung_jawab');
            $table->unsignedBigInteger('idDetailBarang');
            $table->foreign('idDetailBarang')->references('id')->on('data_barang');

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
        Schema::dropIfExists('detail_aset');
    }
}
