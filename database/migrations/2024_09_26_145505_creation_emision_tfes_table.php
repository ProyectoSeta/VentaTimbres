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
        Schema::create('emision_tfes', function (Blueprint $table) {
            $table->increments('id_emision');
            $table->date('fecha_emision');

            $table->integer('key_user')->unsigned();
            $table->foreign('key_user')->references('id')->on('users')->onDelete('cascade');
            
            $table->integer('cantidad_timbres');
            $table->integer('desde');
            $table->integer('hasta');

            $table->date('ingreso_inventario')->nullable();

            $table->integer('estado')->unsigned(); ///////INVENTARIO - ASIGNADO
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
