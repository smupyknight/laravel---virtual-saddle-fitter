<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FixForeignKeys extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('saddles', function($table) {
			$table->dropForeign('saddles_brand_id_foreign');
			$table->dropForeign('saddles_style_id_foreign');

			$table->foreign('brand_id')->references('id')->on('brands');
			$table->foreign('style_id')->references('id')->on('styles');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
	}

}
