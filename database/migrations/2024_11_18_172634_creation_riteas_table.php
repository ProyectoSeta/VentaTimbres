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
        Schema::create('riteas', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('key_contribuyente')->unsigned();
            $table->foreign('key_contribuyente')->references('id_contribuyente')->on('contribuyentes')->onDelete('cascade');
            
            $table->date('fecha_registro');
            $table->date('fecha_renovacion');
            $table->date('fecha_vencimiento');

            $table->integer('estado')->unsigned(); ///////VIGENTE - VENCIDO
            $table->foreign('estado')->references('id_clasificacion')->on('clasificacions')->onDelete('cascade');
           
            $table->string('qr');

            
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
