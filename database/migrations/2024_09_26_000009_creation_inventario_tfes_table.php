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
        Schema::create('inventario_tfes', function (Blueprint $table) {
            $table->increments('correlativo');

            $table->integer('key_taquilla')->unsigned();
            $table->foreign('key_taquilla')->references('id_taquilla')->on('taquillas')->onDelete('cascade');

            $table->integer('key_asignacion')->unsigned();
            $table->foreign('key_asignacion')->references('id_asignacion')->on('asignacion_tfes')->onDelete('cascade');

            $table->integer('cantidad_timbres');
            
            $table->integer('desde');
            $table->integer('hasta');

            $table->integer('key_lote_papel')->unsigned();
            $table->foreign('key_lote_papel')->references('id_lote_papel')->on('emision_papel_tfes')->onDelete('cascade');

            $table->integer('vendido');

            $table->integer('condicion')->unsigned()->nullable(); ///////RESERVA - EN USO - VENDIDO
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
