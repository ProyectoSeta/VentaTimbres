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
        Schema::create('tramites', function (Blueprint $table) {
            $table->increments('id_tramite');

            $table->string('tramite');

            $table->integer('key_ente')->unsigned();
            $table->foreign('key_ente')->references('id_ente')->on('entes')->onDelete('cascade');

            $table->integer('alicuota')->unsigned(); ///////UCD - PORCENTAJE
            $table->foreign('alicuota')->references('id_tipo')->on('tipos')->onDelete('cascade');

            $table->float('natural')->nullable();
            $table->float('juridico')->nullable();

            $table->float('small')->nullable();
            $table->float('medium')->nullable();
            $table->float('large')->nullable();

            $table->float('porcentaje')->nullable();

            

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
