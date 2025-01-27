<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterHourseTable extends Migration
{

	/**
	* Run the migrations.
	*
	* @return void
	*/
	public function up()
	{
		DB::statement('ALTER TABLE horses CHANGE girth_weight girth INT(11)');
	}

	/**
	* Reverse the migrations.
	*
	* @return void
	*/
	public function down()
	{
		DB::statement('ALTER TABLE horses CHANGE girth girth_weight INT(11)');
	}

}
