<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFitterIdToBookings extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('bookings', function (Blueprint $table) {
			$table->unsignedInteger('fitter_id')->after('rider_id')->nullable();
			$table->unsignedInteger('user_id')->nullable()->change();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('bookings', function (Blueprint $table) {
			$table->dropColumn('fitter_id')->nullable();
			$table->unsignedInteger('user_id')->change();
		});
	}

}
