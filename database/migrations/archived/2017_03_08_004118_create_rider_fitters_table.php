<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRiderFittersTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('rider_fitters', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('rider_id')->unsigned();
			$table->integer('company_id')->unsigned();
			$table->datetime('created_at');
			$table->datetime('updated_at');

			$table->foreign('rider_id')->references('id')->on('users')->onDelete('cascade');
			$table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('rider_fitters');
	}

}
