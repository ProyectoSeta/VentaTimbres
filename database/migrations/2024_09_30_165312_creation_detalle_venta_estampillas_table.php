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

            $table->integer('key_tramite')->unsigned(); 
            $table->foreign('key_tramite')->references('id_tramite')->on('tramites')->onDelete('cascade');

            $table->integer('key_denominacion')->unsigned();
            $table->foreign('key_denominacion')->references('id')->on('ucd_denominacions')->onDelete('cascade');

            $table->integer('secuencia');

            $table->integer('nro_correlativo');
            $table->string('nro',9)->unique(); ////correlativo

            $table->integer('key_tira')->unsigned();
            $table->foreign('key_tira')->references('id_tira')->on('estampillas')->onDelete('cascade');


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
