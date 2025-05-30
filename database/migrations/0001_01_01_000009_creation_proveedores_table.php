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
        Schema::create('proveedores', function (Blueprint $table) {
            $table->increments('id_proveedor');

            $table->enum('condicion_identidad',['J','G']);
            $table->integer('nro_identidad');
            
            $table->string('razon_social');
            $table->string('direccion');

            $table->string('nombre_representante');
            
            $table->string('email');

            $table->string('tlf_movil');
            $table->string('tlf_fijo')->nullable();
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
