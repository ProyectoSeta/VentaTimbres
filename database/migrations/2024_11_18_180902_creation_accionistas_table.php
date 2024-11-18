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
        Schema::create('accionistas', function (Blueprint $table) {
            $table->increments('id_acionista');

            $table->integer('key_contribuyente')->unsigned();
            $table->foreign('key_contribuyente')->references('id_contribuyente')->on('contribuyentes')->onDelete('cascade');
            
            $table->enum('condicion_identidad',['V','E']);
            $table->integer('nro_identidad');
            
            $table->string('nombre');
            $table->string('email');
            $table->integer('tlf_movil');
            $table->integer('participacion');

            
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
