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
        Schema::create('cierre_diarios', function (Blueprint $table) {
            $table->increments('id');
            $table->date('fecha')->unique();

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
