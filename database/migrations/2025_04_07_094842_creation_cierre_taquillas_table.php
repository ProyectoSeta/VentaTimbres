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

           $table->decimal('recaudado',20,2);
            $table->decimal('punto',20,2);
            $table->decimal('efectivo',20,2);
            $table->decimal('transferencia',20,2);

            $table->decimal('recaudado_tfe',20,2);
            $table->decimal('recaudado_est',20,2);
            
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
