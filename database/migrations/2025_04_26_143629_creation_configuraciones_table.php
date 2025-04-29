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
        Schema::create('configuraciones', function (Blueprint $table) {
            $table->increments('correlativo');

            $table->string('nombre');
            $table->string('descripcion');
            $table->float('valor')->nullable(); 

            $table->integer('unidad')->unsigned(); 
            $table->foreign('unidad')->references('id_clasificacion')->on('clasificacions')->onDelete('cascade');
            
            $table->integer('module')->unsigned(); 
            $table->foreign('module')->references('id_clasificacion')->on('clasificacions')->onDelete('cascade');
            
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
