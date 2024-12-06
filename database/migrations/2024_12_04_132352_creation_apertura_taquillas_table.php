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
        Schema::create('apertura_taquillas', function (Blueprint $table) {
            $table->increments('correlativo');

            $table->integer('key_taquilla')->unsigned();
            $table->foreign('key_taquilla')->references('id_taquilla')->on('taquillas')->onDelete('cascade');
            
            $table->date('fecha');

            $table->time('apertura_admin');
            $table->time('apertura_taquillero')->nullable();
            $table->time('cierre_taquilla')->nullable();

            $table->float('fondo_caja');

            
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
