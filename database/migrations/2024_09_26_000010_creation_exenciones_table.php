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
        Schema::create('exenciones', function (Blueprint $table) {
            $table->increments('id_exencion');

            $table->integer('key_user')->unsigned();
            $table->foreign('key_user')->references('id')->on('users')->onDelete('cascade');

            $table->integer('key_contribuyente')->unsigned();
            $table->foreign('key_contribuyente')->references('id_contribuyente')->on('contribuyentes')->onDelete('cascade');

            $table->date('fecha');

            $table->integer('key_taquilla')->unsigned()->nullable();
            $table->foreign('key_taquilla')->references('id_taquilla')->on('taquillas')->onDelete('cascade');

            $table->integer('porcentaje_exencion');

            $table->string('doc_solicitud')->nullable(); 
            $table->string('doc_aprobacion')->nullable();

            $table->integer('tipo_pago')->unsigned();  //// OBRA - BIEN - SERVICIO - SUMINISTROS - DEPOSITO 
            $table->foreign('tipo_pago')->references('id_tipo')->on('tipos')->onDelete('cascade');

            $table->string('doc_pago')->nullable();

            $table->string('direccion');
            $table->string('tlf_movil');
            $table->string('tlf_second')->nullable();

            $table->datetime('fecha_asig_taquilla')->nullable();
            $table->datetime('fecha_impresion')->nullable();
            $table->datetime('fecha_entrega')->nullable();

            $table->integer('total_ucd')->nullable();


            $table->integer('estado')->unsigned(); /////    EN PROCESO - EMITIDO - RECIBIDO - ENTREGADO - SOLVENTE
            $table->foreign('estado')->references('id_clasificacion')->on('clasificacions')->onDelete('cascade');


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
