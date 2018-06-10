<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterHorsesTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('horses', function(Blueprint $table) {
			$table->dropColumn('length');
			$table->string('microchip_number')->after('photo')->nullable();
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
			$table->dropColumn('microchip_number');
			$table->decimal('length', 5, 2);
		});
	}

}
