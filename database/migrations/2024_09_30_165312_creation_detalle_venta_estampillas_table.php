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
            $table->increments('correlativo');

            $table->integer('key_venta')->unsigned()->nullable();
            $table->foreign('key_venta')->references('id_venta')->on('ventas')->onDelete('cascade');

            $table->integer('key_detalle_venta')->unsigned();
            $table->foreign('key_detalle_venta')->references('correlativo')->on('detalle_ventas')->onDelete('cascade');

            $table->integer('key_denominacion')->unsigned();
            $table->foreign('key_denominacion')->references('id')->on('ucd_denominacions')->onDelete('cascade');

            $table->integer('nro_timbre')->unique(); ////correlativo de papel

            $table->integer('key_detalle_asignacion')->unsigned();
            $table->foreign('key_detalle_asignacion')->references('correlativo')->on('detalle_asignacion_estampillas')->onDelete('cascade');

            $table->string('serial')->unique(); ////correlativo de denominacion

            $table->string('qr')->unique();

           


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
