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
        Schema::create('data_organismos', function (Blueprint $table) {
            $table->increments('correlativo');

            $table->integer('key_contribuyente')->unsigned();
            $table->foreign('key_contribuyente')->references('id_contribuyente')->on('contribuyentes')->onDelete('cascade');
            
            $table->string('domicilio');

            $table->integer('key_municipio')->unsigned();
            $table->foreign('key_municipio')->references('id')->on('municipios')->onDelete('cascade');

            $table->integer('key_parroquia')->unsigned();
            $table->foreign('key_parroquia')->references('id')->on('parroquias')->onDelete('cascade');

            /////// ENTE ADSCRITO
            $table->enum('adscrito',['No','Si']);
            $table->enum('condicion_rif_ente_ads',['G'])->nullable();
            $table->integer('nro_rif_ente_ads')->nullable();
            $table->string('nombre_ente_ads')->nullable();

            ///////MAXIMA AUTORIDAD
            $table->enum('ci_condicion_max_aut',['V','E']);
            $table->integer('ci_nro_max_aut')->unique();
            $table->string('nombre_max_aut');
            $table->string('cargo_max_aut');
            $table->string('email_max_aut');

            $table->string('tlf_movil');
            $table->string('tlf_fijo')->nullable();

            $table->string('doc_rif');
            $table->string('gaceta_nomb_doc');
            $table->date('fecha_vec_rif');


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
