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
        Schema::create('asignacion_estampillas', function (Blueprint $table) {
            $table->increments('id_asignacion');

            $table->integer('key_user')->unsigned();
            $table->foreign('key_user')->references('id')->on('users')->onDelete('cascade');

            $table->date('fecha');

            $table->integer('key_taquilla')->unsigned();
            $table->foreign('key_taquilla')->references('id_taquilla')->on('taquillas')->onDelete('cascade');

            $table->integer('condicion')->unsigned(); ///////SIN RECIBIR - RECIBIDO
            $table->foreign('condicion')->references('id_clasificacion')->on('clasificacions')->onDelete('cascade');

            $table->date('fecha_recibido')->nullable();

            $table->integer('inventario')->unsigned(); ///////UCD - UT
            $table->foreign('inventario')->references('id_tipo')->on('tipos')->onDelete('cascade');
 
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
