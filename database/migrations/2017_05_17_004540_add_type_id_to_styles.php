<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTypeIdToStyles extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('styles', function(Blueprint $table) {
			$table->integer('type_id')->unsigned()->after('brand_id');
			$table->foreign('type_id')->references('id')->on('types')->onDelete('cascade');
	 });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('styles', function(Blueprint $table) {
			$table->dropForeign('styles_type_id_foreign');
			$table->dropColumn('type_id');
	 });
	}

}
