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
        Schema::create('detalle_venta_estampillas', function (Blueprint $table) {
            $table->increments('id_detalle');

            $table->integer('key_venta')->unsigned();
            $table->foreign('key_venta')->references('id_venta')->on('ventas')->onDelete('cascade');

            $table->integer('key_tramite')->unsigned(); ///////FORMA 14 - ESTAMPILLA
            $table->foreign('key_tramite')->references('id_tramite')->on('tramites')->onDelete('cascade');

            $table->integer('denominacion');
            $table->integer('nro_timbre')->unique(); ////correlativo


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
