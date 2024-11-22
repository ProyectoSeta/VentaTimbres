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

			$table->timestamps();
	    });

	    Schema::create('municipios',function (Blueprint $table)
	    {
	        $table->increments('id');
	        $table->integer('estado_id')->unsigned();
	        $table->string('municipio');
	        $table->foreign('estado_id')->references('id')->on('estados');

			$table->timestamps();
	    });

	    Schema::create('parroquias',function (Blueprint $table)
	    {
	        $table->increments('id');
	        $table->integer('municipio_id')->unsigned();
	        $table->string('parroquia');
	        $table->foreign('municipio_id')->references('id')->on('municipios');

			$table->timestamps();
	    });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		
	}

};
