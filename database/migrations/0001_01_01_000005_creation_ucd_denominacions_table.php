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
        Schema::create('ucd_denominacions', function (Blueprint $table) {
            $table->increments('id');

            $table->float('denominacion');
            $table->enum('forma01',['false','true']);
            $table->enum('forma14',['false','true']);
            $table->enum('estampillas',['false','true']);

            $table->string('identificador',1)->unique();

            $table->integer('alicuota')->unsigned(); ///////UCD - PORCENTAJE
            $table->foreign('alicuota')->references('id_tipo')->on('tipos')->onDelete('cascade');
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
