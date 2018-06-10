<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStateToRidersAndHorses extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('riders', function(Blueprint $table) {
			$table->string('state', 3)->after('suburb');
		});

		Schema::table('horses', function(Blueprint $table) {
			$table->string('state', 3)->after('suburb');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('riders', function(Blueprint $table) {
			$table->dropColumn('state');
		});

		Schema::table('horses', function(Blueprint $table) {
			$table->dropColumn('state');
		});
	}

}
