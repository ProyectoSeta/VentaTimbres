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
        Schema::create('actividades_economicas', function (Blueprint $table) {
            $table->increments('id_actividad');

            $table->string('sector');
            $table->string('ramo');

            $table->string('cod');
            $table->string('descripcion');
           
            
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
