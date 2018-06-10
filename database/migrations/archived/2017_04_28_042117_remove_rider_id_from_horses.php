<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveRiderIdFromHorses extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('horses', function(Blueprint $table) {
			$table->dropForeign('horses_rider_id_foreign');
			$table->dropColumn('rider_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('horses', function(Blueprint $table) {
			$table->integer('rider_id')->unsigned();
			$table->foreign('rider_id')->references('id')->on('horses')->onDelete('cascade');
		});
	}

}
