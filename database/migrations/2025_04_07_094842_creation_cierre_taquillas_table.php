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
        Schema::create('cierre_taquillas', function (Blueprint $table) {
            $table->increments('id');
            $table->date('fecha');

            $table->integer('key_taquilla')->unsigned();
            $table->foreign('key_taquilla')->references('id_taquilla')->on('taquillas')->onDelete('cascade');

            $table->float('recaudado');
            $table->float('punto');
            $table->float('efectivo');

            $table->float('recaudado_tfe');
            $table->float('recaudado_est');
            
            $table->integer('cantidad_tfe');
            $table->integer('cantidad_est');
            
            
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
