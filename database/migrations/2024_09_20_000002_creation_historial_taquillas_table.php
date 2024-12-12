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
        Schema::create('historial_taquillas', function (Blueprint $table) {
            $table->increments('correlativo');

            $table->integer('key_taquilla')->unsigned();
            $table->foreign('key_taquilla')->references('id_taquilla')->on('taquillas')->onDelete('cascade');

            $table->integer('key_funcionario')->unsigned();
            $table->foreign('key_funcionario')->references('id_funcionario')->on('funcionarios')->onDelete('cascade');

            $table->date('desde');
            $table->date('hasta')->nullable();

            
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
