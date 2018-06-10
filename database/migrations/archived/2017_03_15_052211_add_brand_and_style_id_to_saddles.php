<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBrandAndStyleIdToSaddles extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('saddles', function(Blueprint $table) {
			$table->dropColumn('type');
			$table->dropColumn('brand');
			$table->integer('brand_id')->unsigned()->nullable()->after('name');
			$table->integer('style_id')->unsigned()->nullable()->after('brand_id');

			$table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade');
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
		Schema::table('saddles', function(Blueprint $table) {
			$table->dropForeign('saddles_brand_id_foreign');
			$table->dropForeign('saddles_style_id_foreign');

			$table->dropColumn('brand_id');
			$table->dropColumn('style_id');
			$table->string('type')->after('name');
			$table->string('brand')->after('type');
		});
	}

}
