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
        Schema::create('estampillas', function (Blueprint $table) {
            $table->increments('id_tira');

            $table->integer('key_emision')->unsigned();
            $table->foreign('key_emision')->references('id_emision')->on('emision_estampillas')->onDelete('cascade');
            
            $table->integer('key_denominacion')->unsigned();
            $table->foreign('key_denominacion')->references('id')->on('ucd_denominacions')->onDelete('cascade');

            $table->integer('cantidad');
            $table->integer('desde');
            $table->integer('hasta');
            

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
