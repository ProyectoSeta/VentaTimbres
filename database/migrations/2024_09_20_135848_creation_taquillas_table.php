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
        Schema::create('taquillas', function (Blueprint $table) {
            $table->increments('id_taquilla');

            $table->integer('key_sede')->unsigned();
            $table->foreign('key_sede')->references('id_sede')->on('sedes')->onDelete('cascade');

            $table->integer('key_funcionario')->unsigned();
            $table->foreign('key_funcionario')->references('id_funcionario')->on('funcionarios')->onDelete('cascade');

            $table->timestamps();
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
