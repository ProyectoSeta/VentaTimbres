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
        Schema::create('emision_estampillas', function (Blueprint $table) {
            $table->increments('id_emision');
            $table->date('fecha_emision');

            $table->integer('key_user')->unsigned();
            $table->foreign('key_user')->references('id')->on('users')->onDelete('cascade');
            
            $table->date('ingreso_inventario')->nullable();
            $table->string('qr')->unique()->nullable();

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
