<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingsTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('bookings', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('client_id')->unsigned();
			$table->integer('horse_id')->unsigned();
			$table->integer('rider_id')->unsigned();
			$table->datetime('date');
			$table->datetime('created_at');
			$table->datetime('updated_at');

			$table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
			$table->foreign('horse_id')->references('id')->on('horses')->onDelete('cascade');
			$table->foreign('rider_id')->references('id')->on('riders')->onDelete('cascade');
	 });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('bookings');
	}

}
