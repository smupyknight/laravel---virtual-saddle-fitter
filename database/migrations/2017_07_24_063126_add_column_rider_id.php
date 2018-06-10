<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnRiderId extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('saddles', function (Blueprint $table) {
			$table->integer('rider_id')->unsigned()->after('horse_id');

			$table->foreign('rider_id')->references('id')->on('riders');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('saddles', function (Blueprint $table) {
			$table->dropForeign('saddles_rider_id_foreign');
			$table->dropColumn('rider_id');
		});
	}

}
