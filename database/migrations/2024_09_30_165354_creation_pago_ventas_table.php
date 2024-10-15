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
        Schema::create('pago_ventas', function (Blueprint $table) {
            $table->increments('id_pago');

            $table->integer('key_venta')->unsigned();
            $table->foreign('key_venta')->references('id_venta')->on('ventas')->onDelete('cascade');

            $table->integer('metodo')->unsigned(); ///////FORMA 14 - ESTAMPILLA
            $table->foreign('metodo')->references('id_tipo')->on('tipos')->onDelete('cascade');

            $table->integer('comprobante'); 
            $table->decimal('monto');


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
