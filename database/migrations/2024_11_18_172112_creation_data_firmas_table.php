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
        Schema::create('data_firmas', function (Blueprint $table) {
            $table->increments('correlativo');

            $table->integer('key_contribuyente')->unsigned();
            $table->foreign('key_contribuyente')->references('id_contribuyente')->on('contribuyentes')->onDelete('cascade');
            
            $table->string('domicilio');

            $table->integer('key_municipio')->unsigned();
            $table->foreign('key_municipio')->references('id')->on('municipios')->onDelete('cascade');

            $table->integer('key_parroquia')->unsigned();
            $table->foreign('key_parroquia')->references('id')->on('parroquias')->onDelete('cascade');

            $table->date('fecha_vec_rif');
            $table->string('doc_rif');

            $table->enum('ci_condicion',['V','E']);
            $table->string('ci_nro',12)->unique();

            $table->string('tlf_movil');
            $table->string('tlf_fijo')->nullable();

            $table->string('doc_ci');
            
            
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
