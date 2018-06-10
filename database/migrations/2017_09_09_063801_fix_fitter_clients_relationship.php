<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FixFitterClientsRelationship extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('client_fitter', function ($table) {
			$table->increments('id');
			$table->integer('client_id')->unsigned();
			$table->integer('fitter_id')->unsigned();

			$table->foreign('client_id')->references('id')->on('clients');
			$table->foreign('fitter_id')->references('id')->on('fitters');
		});

		foreach (DB::table('clients_fitters')->get() as $relationship) {
			DB::table('client_fitter')->insert(
				['client_id' => $relationship->client_id, 'fitter_id' => $relationship->fitter_id]
			);
		}

		Schema::drop('clients_fitters');
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::create('clients_fitters', function ($table) {
			$table->increments('id');
			$table->integer('client_id')->unsigned();
			$table->integer('fitter_id')->unsigned();

			$table->foreign('client_id')->references('id')->on('clients');
			$table->foreign('fitter_id')->references('id')->on('fitters');

			$table->timestamps();
		});

		foreach (DB::table('client_fitter')->get() as $relationship) {
			DB::table('clients_fitters')->insert(
				['client_id' => $relationship->client_id, 'fitter_id' => $relationship->fitter_id]
			);
		}

		Schema::drop('client_fitter');
	}

}