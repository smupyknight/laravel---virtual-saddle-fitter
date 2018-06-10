<?php

namespace Tests;

use DB;
use Artisan;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
	use CreatesApplication;

	public $baseUrl = 'http://localhost';

	// Set $migrated as true to skip migration for sometime development
	// protected static $migrated = false;
	protected static $migrated = true;

	public function setUp()
	{
		parent::setUp();

		// If this is the first test of the class, drop all tables in the
		// database and re-migrate.
		if (!self::$migrated) {
			self::dropAllTables();
			Artisan::call('migrate');
			self::$migrated = true;
		}

		self::resetDatabase();
	}

	public static function resetDatabase()
	{
		$tables = DB::table('information_schema.TABLES')
			->where('TABLE_SCHEMA', env('DB_DATABASE'))
			->where('AUTO_INCREMENT', '!=', 1)
			->pluck('TABLE_NAME');

		DB::statement('SET foreign_key_checks = 0');

		foreach ($tables as $table) {
			DB::statement("TRUNCATE TABLE `$table`");
		}

		DB::statement('SET foreign_key_checks = 1');
	}

	public static function dropAllTables()
	{
		$tables = DB::table('information_schema.TABLES')
			->where('TABLE_SCHEMA', env('DB_DATABASE'))
			->pluck('TABLE_NAME');

		DB::statement('SET foreign_key_checks = 0');

		foreach ($tables as $table) {
			DB::statement("DROP TABLE `$table`");
		}

		DB::statement('SET foreign_key_checks = 1');
	}

}
