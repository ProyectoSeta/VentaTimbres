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
        Schema::create('estampillas', function (Blueprint $table) {
            $table->increments('id_tira');

            $table->integer('key_emision')->unsigned();
            $table->foreign('key_emision')->references('id_emision')->on('emision_estampillas')->onDelete('cascade');
            
            $table->integer('key_denominacion')->unsigned();
            $table->foreign('key_denominacion')->references('id')->on('ucd_denominacions')->onDelete('cascade');

            $table->integer('cantidad');
            $table->integer('secuencia');

            $table->integer('desde_correlativo');
            $table->integer('hasta_correlativo');

            $table->string('desde',9);
            $table->string('hasta',9);
            
            $table->integer('estado')->unsigned(); ///////EMISIÓN - INVENTARIO - ASIGNADA (TOTAL)
            $table->foreign('estado')->references('id_clasificacion')->on('clasificacions')->onDelete('cascade');

            $table->integer('cantidad_asignada');

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
