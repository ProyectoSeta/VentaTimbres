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
        Schema::create('detalle_ventas', function (Blueprint $table) {
            $table->increments('correlativo');

            $table->integer('key_venta')->unsigned();
            $table->foreign('key_venta')->references('id_venta')->on('ventas')->onDelete('cascade');

            $table->integer('key_tramite')->unsigned();
            $table->foreign('key_tramite')->references('id_tramite')->on('tramites')->onDelete('cascade');

            $table->integer('forma')->unsigned(); ///////FORMA 14 - ESTAMPILLAS
            $table->foreign('forma')->references('id_tipo')->on('tipos')->onDelete('cascade');

            $table->integer('cantidad');

            $table->float('metros')->nullable();
            $table->float('capital')->nullable();
            $table->integer('folios')->nullable();

            $table->integer('ucd')->nullable();
            $table->float('bs')->nullable();
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
