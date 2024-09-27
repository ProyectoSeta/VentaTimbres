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
        Schema::create('detalle_emision_rollos', function (Blueprint $table) {
            $table->increments('correlativo');

            $table->integer('key_emision')->unsigned();
            $table->foreign('key_emision')->references('id_emision')->on('emision_rollos')->onDelete('cascade');
            
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
