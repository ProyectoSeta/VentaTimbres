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
        Schema::create('inventario_estampillas', function (Blueprint $table) {
            $table->increments('id_inventario_estampilla');

            $table->integer('key_asignacion_ucd')->unsigned();
            $table->foreign('key_asignacion_ucd')->references('id_asignacion_ucd')->on('asignacion_ucd_estampillas')->onDelete('cascade');
            
            $table->integer('key_lote_papel')->unsigned();
            $table->foreign('key_lote_papel')->references('id_lote_papel')->on('emision_papel_estampillas')->onDelete('cascade');

            $table->integer('key_denominacion')->unsigned();
            $table->foreign('key_denominacion')->references('id')->on('ucd_denominacions')->onDelete('cascade');
            
            $table->integer('cantidad_timbres');
            
            $table->integer('desde');
            $table->integer('hasta');

            $table->integer('secuencia');
            
           
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
