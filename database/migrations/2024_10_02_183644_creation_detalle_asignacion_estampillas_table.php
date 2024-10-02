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
        Schema::create('detalle_asignacion_estampillas', function (Blueprint $table) {
            $table->increments('id_detalle');

            $table->integer('key_asignacion')->unsigned();
            $table->foreign('key_asignacion')->references('id_asignacion')->on('asignacion_estampillas')->onDelete('cascade');

            
            $table->integer('ucd_denominacion',4);
            $table->integer('cantidad');


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
