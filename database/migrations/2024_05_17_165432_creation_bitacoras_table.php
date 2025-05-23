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
        Schema::create('bitacoras', function (Blueprint $table) {
            $table->increments('correlativo');
            $table->integer('key_user')->unsigned();
            $table->foreign('key_user')->references('id')->on('users')->onDelete('cascade');
            $table->integer('key_modulo')->unsigned();
            $table->foreign('key_modulo')->references('id_modulo')->on('modulos')->onDelete('cascade');
            $table->date('fecha');
            $table->string('accion');

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
