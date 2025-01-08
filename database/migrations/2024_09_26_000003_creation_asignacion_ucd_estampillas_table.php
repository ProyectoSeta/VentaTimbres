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
        Schema::create('asignacion_ucd_estampillas', function (Blueprint $table) {
            $table->increments('id_asignacion_ucd');

            // $table->integer('key_lote_papel')->unsigned();
            // $table->foreign('key_lote_papel')->references('id_lote_papel')->on('emision_papel_estampillas')->onDelete('cascade');

            $table->integer('key_user')->unsigned();
            $table->foreign('key_user')->references('id')->on('users')->onDelete('cascade');

            $table->date('fecha');
            $table->time('hora');


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
