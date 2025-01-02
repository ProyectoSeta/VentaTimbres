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
        Schema::create('detalle_venta_tfes', function (Blueprint $table) {
            $table->increments('correlativo');

            $table->integer('key_venta')->unsigned()->nullable();
            $table->foreign('key_venta')->references('id_venta')->on('ventas')->onDelete('cascade');

            $table->integer('key_denominacion')->unsigned();
            $table->foreign('key_denominacion')->references('id')->on('ucd_denominacions')->onDelete('cascade');

            $table->integer('nro_timbre')->unique(); ////correlativo de papel
            $table->string('serial')->unique(); ////correlativo de denominacion

            $table->integer('key_tramite')->unsigned(); 
            $table->foreign('key_tramite')->references('id_tramite')->on('tramites')->onDelete('cascade');

            $table->string('qr')->unique();

            // $table->integer('key_lote')->unsigned();
            // $table->foreign('key_lote')->references('id_lote')->on('inventario_tfes')->onDelete('cascade');



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
