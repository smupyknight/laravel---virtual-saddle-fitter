<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToSaddles extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('saddles', function (Blueprint $table) {
			$table->integer('girth')->unsigned();
			$table->integer('leathers')->unsigned();
			$table->integer('irons')->unsigned();
			$table->enum('condition', ['New', 'Old']);
			$table->string('saddle_balance');
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
			$table->dropColumn('girth');
			$table->dropColumn('leathers');
			$table->dropColumn('irons');
			$table->dropColumn('condition');
			$table->dropColumn('saddle_balance');
		});
	}

}
