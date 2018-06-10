<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('companies', function (Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->string('abn');
			$table->string('phone');
			$table->string('email');
			$table->string('address');
			$table->string('description');
			$table->datetime('created_at');
			$table->datetime('updated_at');
		});

		Schema::table('users', function (Blueprint $table) {
			$table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users', function($table) {
			$table->dropForeign('users_company_id_foreign');
		});

		Schema::drop('companies');
	}

}
