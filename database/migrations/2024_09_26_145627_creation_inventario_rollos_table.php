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
        Schema::create('inventario_rollos', function (Blueprint $table) {
            $table->increments('id_rollo');

            $table->integer('key_emision')->unsigned();
            $table->foreign('key_emision')->references('id_emision')->on('emision_rollos')->onDelete('cascade');
            
            $table->integer('desde');
            $table->integer('hasta');
            
            $table->integer('estado')->unsigned(); ///////INVENTARIO - ASIGNADO
            $table->foreign('estado')->references('id_clasificacion')->on('clasificacions')->onDelete('cascade');

            $table->integer('key_taquilla')->unsigned()->nullable();
            $table->foreign('key_taquilla')->references('id_taquilla')->on('taquillas')->onDelete('cascade');
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
