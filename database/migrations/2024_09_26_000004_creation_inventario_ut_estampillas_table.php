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
        Schema::create('inventario_ut_estampillas', function (Blueprint $table) {
            $table->increments('id_inventario_estampilla');

            $table->integer('key_denominacion')->unsigned();
            $table->foreign('key_denominacion')->references('id')->on('ucd_denominacions')->onDelete('cascade');
            
            $table->integer('cantidad_timbres');
            
            $table->integer('desde');
            $table->integer('hasta');

            $table->integer('asignado');

            $table->integer('estado')->unsigned(); ///// INVENTARIO - ASIGNADO
            $table->foreign('estado')->references('id_clasificacion')->on('clasificacions')->onDelete('cascade');
            
           
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
