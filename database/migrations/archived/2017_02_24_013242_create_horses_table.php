<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHorsesTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('horses', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('rider_id')->unsigned();
			$table->string('name');
			$table->string('breed');
			$table->string('colour');
			$table->string('discipline');
			$table->integer('weight');
			$table->integer('girth_weight');
			$table->integer('height');
			$table->integer('age');
			$table->enum('sex', ['Male', 'Female']);
			$table->datetime('created_at');
			$table->datetime('updated_at');

			$table->foreign('rider_id')->references('id')->on('users')->onDelete('cascade');
		});

		Schema::table('bookings', function (Blueprint $table) {
			$table->foreign('horse_id')->references('id')->on('horses')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('horses', function($table) {
			$table->dropForeign('horses_rider_id_foreign');
		});

		Schema::table('bookings', function($table) {
			$table->dropForeign('bookings_horse_id_foreign');
		});

		Schema::drop('horses');
	}

}
