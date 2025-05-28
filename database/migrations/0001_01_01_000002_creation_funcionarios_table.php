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
        Schema::create('funcionarios', function (Blueprint $table) {
            $table->increments('id_funcionario');

            $table->enum('ci_condicion',['V','E']);
            $table->string('ci_nro',12)->unique();

            $table->string('nombre');
            $table->string('cargo');

            $table->integer('key')->unique()->nullable();

            $table->integer('estado')->unsigned(); ///////HABILITADO - DESHABILITADO
            $table->foreign('estado')->references('id_clasificacion')->on('clasificacions')->onDelete('cascade');

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
