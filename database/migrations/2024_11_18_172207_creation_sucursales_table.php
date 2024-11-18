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
        Schema::create('sucursales', function (Blueprint $table) {
            $table->increments('id_sucursal');

            $table->integer('key_contribuyente')->unsigned();
            $table->foreign('key_contribuyente')->references('id_contribuyente')->on('contribuyentes')->onDelete('cascade');
            
            $table->string('domicilio');

            $table->integer('key_municipio')->unsigned();
            $table->foreign('key_municipio')->references('id')->on('municipios')->onDelete('cascade');

            $table->integer('key_parroquia')->unsigned();
            $table->foreign('key_parroquia')->references('id')->on('parroquias')->onDelete('cascade');

            $table->string('doc_rif');
            $table->date('fecha_vec_rif');

            ///////// REPRESENTANTE LEGAL
            $table->string('nombre_repr');
            $table->enum('rif_condicion_repr',['V','E']);
            $table->integer('rif_nro_repr')->unique();
            
            $table->string('domicilio_repr');

            $table->integer('tlf_movil_repr');
            $table->integer('tlf_fijo_repr')->nullable();

            $table->date('fecha_vec_rif_repr');
            $table->string('doc_rif_repr');
            $table->string('ci_rif_repr');
           


            
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
