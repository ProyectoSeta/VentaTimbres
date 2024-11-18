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
        Schema::create('data_naturales', function (Blueprint $table) {
            $table->increments('correlativo');

            $table->integer('key_contribuyente')->unsigned();
            $table->foreign('key_contribuyente')->references('id_contribuyente')->on('contribuyentes')->onDelete('cascade');
            
            $table->string('domicilio');

            $table->integer('key_municipio')->unsigned();
            $table->foreign('key_municipio')->references('id')->on('municipios')->onDelete('cascade');

            $table->integer('key_parroquia')->unsigned();
            $table->foreign('key_parroquia')->references('id')->on('parroquias')->onDelete('cascade');

            $table->string('doc_rif');
            $table->string('doc_ci');

            $table->integer('tlf_movil');
            $table->integer('tlf_fijo')->nullable();

            $table->date('fecha_nacimiento');

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
