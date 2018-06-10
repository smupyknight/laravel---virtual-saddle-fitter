<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFitchecksTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('fitchecks', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('rider_id')->unsigned();
			$table->integer('horse_id')->unsigned();
			$table->integer('saddle_id')->unsigned();
			$table->integer('user_id')->unsigned();
			$table->text('field_data');
			$table->datetime('created_at');
			$table->datetime('updated_at');

			$table->foreign('rider_id')->references('id')->on('riders')->onDelete('cascade');
			$table->foreign('horse_id')->references('id')->on('horses')->onDelete('cascade');
			$table->foreign('saddle_id')->references('id')->on('saddles')->onDelete('cascade');
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('fitchecks');
	}

}
