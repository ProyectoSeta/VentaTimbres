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
        Schema::create('registro_actas', function (Blueprint $table) {
            $table->increments('correlativo');

            $table->integer('key_contribuyente')->unsigned();
            $table->foreign('key_contribuyente')->references('id_contribuyente')->on('contribuyentes')->onDelete('cascade');
            
            $table->string('nombre_registro');
            $table->date('fecha_registro');
            
            $table->integer('numero_registro');
            $table->string('tomo');
            $table->string('folio');
            $table->float('capital_social');

            $table->string('doc_registro');
            $table->string('doc_acta_ultima')->nullable();

            
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
