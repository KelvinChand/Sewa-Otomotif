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
        Schema::create('sewas', function (Blueprint $table) {
            $table->id('id_sewas');
            $table->unsignedBigInteger('id_kendaraans');
            $table->foreign('id_kendaraans')->references('id_kendaraans')->on('kendaraans');
            $table->string('nama_customer',50);
            $table->date('tanggal_mulai_sewa');
            $table->date('tanggal_berakhir_sewa');
            $table->double('harga_sewa');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sewas');
    }
};
