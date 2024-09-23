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
        Schema::create('tramites', function (Blueprint $table) {
            $table->increments('id_tramite');

            $table->string('tramite');

            $table->integer('key_ente')->unsigned();
            $table->foreign('key_ente')->references('id_ente')->on('entes')->onDelete('cascade');

            $table->integer('ucd');

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
