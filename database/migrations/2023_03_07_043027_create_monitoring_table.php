<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMonitoringTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('monitoring', function (Blueprint $table) {
            $table->id();
            $table->date('tgl_monitoring');
            $table->string('deskripsi');
            $table->enum('kondisi', ['Baik', 'RusakRingan', 'RusakBerat'])->default('Baik');
            $table->string('pj');
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
        Schema::dropIfExists('monitoring');
    }
}
