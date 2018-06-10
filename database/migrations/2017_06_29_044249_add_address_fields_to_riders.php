<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAddressFieldsToRiders extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('riders', function(Blueprint $table) {
			$table->string('postcode')->after('address');
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
		Schema::table('riders', function(Blueprint $table) {
			$table->dropColumn('postcode');
			$table->dropColumn('suburb');
		});
	}

}
