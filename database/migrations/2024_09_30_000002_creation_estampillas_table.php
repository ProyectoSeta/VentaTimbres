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

            $table->integer('desde_correlativo')->unique();
            $table->integer('hasta_correlativo')->unique();

            $table->integer('desde')->unique();
            $table->integer('hasta')->unique();
            
            $table->integer('estado')->unsigned(); ///////EMISIÓN - INVENTARIO
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
