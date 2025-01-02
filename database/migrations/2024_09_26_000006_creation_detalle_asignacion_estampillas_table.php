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
        Schema::create('detalle_asignacion_estampillas', function (Blueprint $table) {
            $table->increments('correlativo');

            $table->integer('key_asignacion')->unsigned();
            $table->foreign('key_asignacion')->references('id_asignacion')->on('asignacion_estampillas')->onDelete('cascade');

            $table->integer('key_inventario_estampilla')->unsigned();
            $table->foreign('key_inventario_estampilla')->references('id_inventario_estampilla')->on('inventario_estampillas')->onDelete('cascade');

            $table->integer('key_denominacion')->unsigned();
            $table->foreign('key_denominacion')->references('id')->on('ucd_denominacions')->onDelete('cascade');

            $table->integer('cantidad_timbres');
            
            $table->integer('desde');
            $table->integer('hasta');

            $table->integer('vendido');

            $table->integer('condicion')->unsigned(); ///////RESERVA - EN USO - VENDIDO
            $table->foreign('condicion')->references('id_clasificacion')->on('clasificacions')->onDelete('cascade');
 
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
