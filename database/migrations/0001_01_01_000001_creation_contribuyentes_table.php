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
        Schema::create('contribuyentes', function (Blueprint $table) {
            $table->increments('id_contribuyente');

            $table->enum('identidad_condicion',['V','E','J','G']);
            $table->string('identidad_nro',12)->unique();

            $table->string('nombre_razon');

            // $table->integer('type_contribuyente')->unsigned(); ///////natural - firma personal - ente
            // $table->foreign('type_contribuyente')->references('id_tipo')->on('tipos')->onDelete('cascade');

            $table->timestamps();
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
