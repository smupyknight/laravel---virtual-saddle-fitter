<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOndeleteToSaddlesForeign extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('saddles', function (Blueprint $table) {
			$table->dropForeign('saddles_brand_id_foreign');
			$table->dropForeign('saddles_horse_id_foreign');
			$table->dropForeign('saddles_rider_id_foreign');
			$table->dropForeign('saddles_style_id_foreign');

			$table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade');
			$table->foreign('horse_id')->references('id')->on('horses')->onDelete('cascade');
			$table->foreign('rider_id')->references('id')->on('riders')->onDelete('cascade');
			$table->foreign('style_id')->references('id')->on('styles')->onDelete('cascade');
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
