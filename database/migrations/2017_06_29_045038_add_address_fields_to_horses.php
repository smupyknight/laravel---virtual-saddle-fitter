<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAddressFieldsToHorses extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('horses', function(Blueprint $table) {
			$table->string('postcode')->after('paddock_address');
			$table->string('suburb')->after('postcode');
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
			$table->dropColumn('postcode');
			$table->dropColumn('suburb');
		});
	}

}
