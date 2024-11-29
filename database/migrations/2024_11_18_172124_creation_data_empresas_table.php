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
        Schema::create('data_empresas', function (Blueprint $table) {
            $table->increments('correlativo');

            $table->integer('key_contribuyente')->unsigned();
            $table->foreign('key_contribuyente')->references('id_contribuyente')->on('contribuyentes')->onDelete('cascade');
            
            $table->string('domicilio');

            $table->integer('key_estado')->unsigned();
            $table->foreign('key_estado')->references('id')->on('estados')->onDelete('cascade');

            $table->integer('key_municipio')->unsigned();
            $table->foreign('key_municipio')->references('id')->on('municipios')->onDelete('cascade');

            $table->integer('key_parroquia')->unsigned();
            $table->foreign('key_parroquia')->references('id')->on('parroquias')->onDelete('cascade');

            $table->string('doc_rif');
            $table->date('fecha_vec_rif');

            $table->enum('empresa_estado',['No','Si']);
            $table->enum('sucursales',['No','Si']);

            ///////// REPRESENTANTE LEGAL
            $table->string('nombre_repr')->nullable();
            $table->enum('rif_condicion_repr',['V','E'])->nullable();
            $table->integer('rif_nro_repr')->unique()->nullable();
            
            $table->string('domicilio_repr')->nullable();

            $table->integer('tlf_movil_repr')->nullable();
            $table->integer('tlf_fijo_repr')->nullable();

            $table->date('fecha_vec_rif_repr')->nullable();
            $table->string('doc_rif_repr')->nullable();
            $table->string('ci_rif_repr')->nullable();
           

            $table->integer('estado')->unsigned(); /////// EN REVISIÓN - CORRECCIÓN - POR APROBACIÓN - VERIFICADO 
            $table->foreign('estado')->references('id_clasificacion')->on('clasificacions')->onDelete('cascade');

            $table->string('observacion')->nullable();
            $table->date('fecha_ult_obv')->nullable();
            
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
