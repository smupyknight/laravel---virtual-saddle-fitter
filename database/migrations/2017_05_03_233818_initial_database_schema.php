<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InitialDatabaseSchema extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up ()
	{
		Schema::create('fitters', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->string('abn', 11);
			$table->string('phone', 15);
			$table->string('email');
			$table->string('address');
			$table->string('suburb');
			$table->string('postcode', 4);
			$table->string('state', 3);
			$table->string('logo');
			$table->datetime('created_at');
			$table->datetime('updated_at');
		});

		Schema::create('clients', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->string('address');
			$table->string('suburb');
			$table->string('postcode', 5);
			$table->string('state', 3);
			$table->datetime('created_at');
			$table->datetime('updated_at');
		});

		Schema::create('clients_users', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('client_id')->unsigned();
			$table->integer('user_id')->unsigned();
			$table->datetime('created_at');
			$table->datetime('updated_at');

			$table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

			$table->unique(['client_id', 'user_id']);
		});

		Schema::create('clients_fitters', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('client_id')->unsigned();
			$table->integer('fitter_id')->unsigned();
			$table->datetime('created_at');
			$table->datetime('updated_at');

			$table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
			$table->foreign('fitter_id')->references('id')->on('fitters')->onDelete('cascade');

			$table->unique(['client_id', 'fitter_id']);
		});

		Schema::create('horses', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('client_id')->unsigned();
			$table->string('stable_name');
			$table->string('breeding_name');
			$table->string('paddock_address');
			$table->string('breed');
			$table->string('colour');
			$table->decimal('height', 5, 2);
			$table->decimal('weight', 5, 2);
			$table->decimal('girth', 5, 2);
			$table->decimal('length', 5, 2);
			$table->integer('age');
			$table->date('dob');
			$table->string('discipline');
			$table->enum('sex', ['Stallion', 'Mare', 'Gelding']);
			$table->string('photo');
			$table->datetime('created_at');
			$table->datetime('updated_at');

			$table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
		});

		Schema::create('riders', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('client_id')->unsigned();
			$table->string('first_name');
			$table->string('last_name');
			$table->string('address');
			$table->string('mobile');
			$table->string('email');
			$table->string('discipline');
			$table->string('stirrup_size');
			$table->string('stirrup_leather');
			$table->integer('height');
			$table->string('jodphur_size');
			$table->boolean('is_vip_member');
			$table->integer('award_points');
			$table->boolean('has_registered_on_website');
			$table->datetime('created_at');
			$table->datetime('updated_at');

			$table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
		});

		Schema::create('brands', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->datetime('created_at');
			$table->datetime('updated_at');
		});

		Schema::create('styles', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('brand_id')->unsigned();
			$table->string('name');
			$table->datetime('created_at');
			$table->datetime('updated_at');

			$table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade');
		});

		Schema::create('saddles', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('horse_id')->unsigned();
			$table->integer('brand_id')->unsigned();
			$table->integer('style_id')->unsigned();
			$table->decimal('price', 5, 2);
			$table->string('serial_number');
			$table->string('size');
			$table->enum('type', ['All Purpose', 'Dressage', 'Endurance', 'Eventing', 'Icelandic', 'Jump', 'Pony', 'Show', 'Special', 'Stock', 'Trekking', 'Western']);
			$table->enum('gullet_size', ['n', 'nm. m', 'mw.w.xw.wxw.xww.xxw']);
			$table->enum('panel_type', ['Flock', 'Cair', 'Flair', 'Foam', 'Felt', 'Latex']);
			$table->enum('seat_style', ['Deep seat', 'Standard', 'Flat seat']);
			$table->date('purchased_at')->nullable();
			$table->integer('warranty_period')->unsigned()->nullable();
			$table->datetime('created_at');
			$table->datetime('updated_at');

			$table->foreign('horse_id')->references('id')->on('horses')->onDelete('cascade');
			$table->foreign('brand_id')->references('id')->on('horses')->onDelete('cascade');
			$table->foreign('style_id')->references('id')->on('horses')->onDelete('cascade');
		});

		Schema::table('users', function (Blueprint $table) {
			$table->integer('client_id')->after('id')->unsigned()->nullable();
			$table->integer('fitter_id')->after('client_id')->unsigned()->nullable();

			$table->dropColumn('name');

			$table->string('first_name')->after('fitter_id');
			$table->string('last_name')->after('first_name');
			$table->string('api_token', 32)->after('password');
			$table->enum('type', ['user', 'fitter-user', 'fitter-admin', 'global-admin'])->after('last_name');

			$table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
			$table->foreign('fitter_id')->references('id')->on('fitters')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down ()
	{
		Schema::disableForeignKeyConstraints();

		Schema::drop('clients');
		Schema::drop('clients_users');
		Schema::drop('clients_fitters');
		Schema::drop('horses');
		Schema::drop('fitters');
		Schema::drop('riders');
		Schema::drop('brands');
		Schema::drop('styles');
		Schema::drop('saddles');

		Schema::table('users', function (Blueprint $table) {
			$table->dropForeign('users_client_id_foreign');
			$table->dropColumn('client_id');
			$table->dropForeign('users_fitter_id_foreign');
			$table->dropColumn('fitter_id');

			$table->string('name');

			$table->dropColumn('first_name');
			$table->dropColumn('last_name');
			$table->dropColumn('api_token');
			$table->dropColumn('type');
		});

		Schema::enableForeignKeyConstraints();
	}

}
