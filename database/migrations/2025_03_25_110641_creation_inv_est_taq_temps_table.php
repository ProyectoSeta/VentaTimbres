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
        Schema::create('inv_est_taq_temps', function (Blueprint $table) {
            $table->increments('id');
            
            $table->integer('key_taquilla')->unsigned()->unique();
            $table->foreign('key_taquilla')->references('id_taquilla')->on('taquillas')->onDelete('cascade');
            
            $table->integer('one_ucd');
            $table->integer('two_ucd');
            $table->integer('three_ucd');
            $table->integer('five_ucd');

            $table->integer('twenty_ut');
            $table->integer('fifty_ut');
            
            $table->date('fecha');
            
            
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
