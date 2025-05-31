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
            $table->increments('correlativo');

            $table->integer('key_venta')->unsigned();
            $table->foreign('key_venta')->references('id_venta')->on('ventas')->onDelete('cascade');

            $table->integer('metodo')->unsigned(); ///////PUNTO - EFECTIVO
            $table->foreign('metodo')->references('id_tipo')->on('tipos')->onDelete('cascade');

            $table->integer('comprobante')->nullable(); 
            $table->decimal('monto',20, 2);
            $table->decimal('anulado',20, 2)->nullable();

            $table->datetime('fecha');

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
