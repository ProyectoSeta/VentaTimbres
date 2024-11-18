<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
	{
		Schema::create('estados',function (Blueprint $table)
	    {
	        $table->increments('id');
	        $table->string('estado');
	        $table->string('iso_3166-2');
	    });

	    Schema::create('municipios',function (Blueprint $table)
	    {
	        $table->increments('id');
	        $table->integer('estado_id')->unsigned();
	        $table->string('municipio');
	        $table->foreign('estado_id')->references('id')->on('estados');
	    });

	    Schema::create('parroquias',function (Blueprint $table)
	    {
	        $table->increments('id');
	        $table->integer('municipio_id')->unsigned();
	        $table->string('parroquia');
	        $table->foreign('municipio_id')->references('id')->on('municipios');
	    });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('estados');
		Schema::drop('municipios');
		Schema::drop('ciudades');
		Schema::drop('parroquias');
	}

};
