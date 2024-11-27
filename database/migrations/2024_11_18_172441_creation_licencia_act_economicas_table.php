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
        Schema::create('licencia_act_economicas', function (Blueprint $table) {
            $table->increments('id_licencia');

            $table->integer('key_contribuyente')->unsigned();
            $table->foreign('key_contribuyente')->references('id_contribuyente')->on('contribuyentes')->onDelete('cascade');
            
            $table->string('nro');

            $table->date('fecha_vencimiento');
            $table->string('doc_licencia');

            
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
