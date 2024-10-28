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
        Schema::create('detalle_estampillas', function (Blueprint $table) {
            $table->increments('correlativo');

            $table->integer('key_tira')->unsigned();
            $table->foreign('key_tira')->references('id_tira')->on('estampillas')->onDelete('cascade');

            $table->integer('key_asignacion')->unsigned();
            $table->foreign('key_asignacion')->references('id_asignacion')->on('asignacion_estampillas')->onDelete('cascade');

            $table->integer('key_denominacion')->unsigned();
            $table->foreign('key_denominacion')->references('id')->on('ucd_denominacions')->onDelete('cascade');

            $table->integer('key_taquilla')->unsigned();
            $table->foreign('key_taquilla')->references('id_taquilla')->on('taquillas')->onDelete('cascade');

            $table->integer('cantidad');

            $table->integer('desde_correlativo');
            $table->integer('hasta_correlativo');

            $table->string('desde',9)->unique();
            $table->string('hasta',9)->unique();


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
