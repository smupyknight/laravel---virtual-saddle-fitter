<?php

use Illuminate\Database\Seeder;

class TestUsersSeeder extends Seeder
{

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		// Test Global Admin
		$global_admin = App\User::where('email', '=', 'testglobaladmin@com.com')->first();

		if ($global_admin) {
			$global_admin->first_name = 'Test';
			$global_admin->last_name = 'GlobalAdmin';
			$global_admin->type = 'global-admin';
			$global_admin->password = bcrypt('tester');
			$global_admin->save();
		} else {
			$global_admin = factory(App\User::class)->create([
				'first_name' => 'Test',
				'last_name'  => 'GlobalAdmin',
				'email'      => 'testglobaladmin@com.com',
				'type'       => 'global-admin',
				'password'   => bcrypt('tester'),
			]);
		}

		// Test Fitter
		$fitter = App\Fitter::where('email', '=', 'testfitter@com.com')->first();

		if ($fitter) {
			$fitter->name = 'Test Fitter';
			$fitter->save();
		} else {
			$fitter = factory(App\Fitter::class)->create([
				'name'  => 'Test Fitter',
				'email' => 'testfitter@com.com',
			]);
		}

		// Test Fitter's Admin user
		$fitter_admin = App\User::where('email', '=', 'testfitteradmin@com.com')->first();

		if ($fitter_admin) {
			$fitter_admin->first_name = 'Test';
			$fitter_admin->last_name = 'FitterAdmin';
			$fitter_admin->fitter_id = $fitter->id;
			$fitter_admin->type = 'fitter-admin';
			$fitter_admin->password = bcrypt('tester');
			$fitter_admin->save();
		} else {
			$fitter_admin = factory(App\User::class)->create([
				'first_name' => 'Test',
				'last_name'  => 'FitterAdmin',
				'email'      => 'testfitteradmin@com.com',
				'fitter_id'  => $fitter->id,
				'type'       => 'fitter-admin',
				'password'   => bcrypt('tester'),
			]);
		}

		// Test Fitter's normal user
		$fitter_user = App\User::where('email', '=', 'testfitteruser@com.com')->first();

		if ($fitter_user) {
			$fitter_user->first_name = 'Test';
			$fitter_user->last_name = 'FitterUser';
			$fitter_user->fitter_id = $fitter->id;
			$fitter_user->type = 'fitter-user';
			$fitter_user->password = bcrypt('tester');
			$fitter_user->save();
		} else {
			$fitter_user = factory(App\User::class)->create([
				'first_name' => 'Test',
				'last_name'  => 'FitterUser',
				'email'      => 'testfitteruser@com.com',
				'fitter_id'  => $fitter->id,
				'type'       => 'fitter-user',
				'password'   => bcrypt('tester'),
			]);
		}

		// Test Fitter's Client
		$fitter_client = App\Client::where('email', '=', 'testfitterclient@com.com')->first();

		if ($fitter_client) {
			$fitter_client->name = 'Test Fitter Client';
			$fitter_client->save();
		} else {
			$fitter_client = factory(App\Client::class)->create([
				'name'  => 'Test Fitter Client',
				'email' => 'testfitterclient@com.com',
			]);
		}

		// Test Fitter Client relationship
		$fitter_client_relation = App\ClientFitter::where('client_id', '=', $fitter_client->id)
												  ->where('fitter_id', '=', $fitter->id)
												  ->first();

		if (!$fitter_client_relation) {
			$fitter_client_relation = factory(App\ClientFitter::class)->create([
				'client_id' => $fitter_client->id,
				'fitter_id' => $fitter->id,
			]);
		}

		// Test Client's user
		$client_user = App\User::where('email', 'testclientuser@com.com')->first();

		if ($client_user) {
			$client_user->first_name = 'Test';
			$client_user->last_name = 'ClientUser';
			$client_user->client_id = $fitter_client->id;
			$client_user->type = 'user';
			$client_user->password = bcrypt('tester');
			$client_user->save();
		} else {
			$client_user = factory(App\User::class)->create([
				'first_name' => 'Test',
				'last_name'  => 'ClientUser',
				'email'      => 'testclientuser@com.com',
				'client_id'  => $fitter_client->id,
				'type'       => 'user',
				'password'   => bcrypt('tester'),
			]);
		}

		// Test Breed
		$test_breed = App\Breed::where('name', 'TestBreed')
							   ->first();

		if (!$test_breed) {
			$test_breed = factory(App\Breed::class)->create([
				'name' => 'TestBreed',
			]);
		}

		// Test Horse for Test Client
		$test_horse = App\Horse::where('stable_name', 'TestHorse_TestClient')->first();

		if ($test_horse) {
			$test_horse->client_id = $fitter_client->id;
			$test_horse->breeding_name = $test_breed->name;
			$test_horse->breed = $test_breed->name;

			$test_horse->save();
		} else {
			$test_horse = factory(App\Horse::class)->create([
				'client_id'     => $fitter_client->id,
				'stable_name'   => 'TestHorse_TestClient',
				'breeding_name' => $test_breed->name,
				'breed'         => $test_breed->name,
			]);
		}

		// Test Rider for Test Client
		$test_rider = App\Rider::where('email', 'testrider@com.com')->first();

		if ($test_rider) {
			$test_rider->client_id = $fitter_client->id;
			$test_rider->first_name = 'TestClient';
			$test_rider->last_name = 'TestRider';
		} else {
			$test_rider = factory(App\Rider::class)->create([
				'client_id'  => $fitter_client->id,
				'first_name' => 'TestClient',
				'last_name'  => 'TestRider',
			]);
		}
	}

}
