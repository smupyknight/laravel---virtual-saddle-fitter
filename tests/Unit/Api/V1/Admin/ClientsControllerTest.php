<?php

namespace Tests\Unit\Api\V1\Admin;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Mail;

class ClientsControllerTest extends TestCase
{

	// FitterAdmin User
	private $admin;
	private $clients;
	private $otherClients;

	// Prepare Tests
	public function setUp()
	{
		parent::setUp();

		$fitter = factory(\App\Fitter::class)->create();
		$this->admin = factory(\App\User::class)->create([
			'fitter_id' => $fitter->id,
			'type'      => 'fitter-admin',
		]);

		// Add clients related to fitter
		$this->clients = factory(\App\Client::class, 5)->create();

		foreach ($this->clients as $client) {
			factory(\App\ClientFitter::class)->create([
				'client_id' => $client->id,
				'fitter_id' => $this->admin->fitter->id,
			]);
		}

		// Add clients not related to fitter
		$this->otherClients = factory(\App\Client::class, 5)->create();
	}

	// FitterAdmin should be able to get list of his clients
	public function testIndex()
	{
		// Test return all data
		$response = $this->actingAs($this->admin, 'api')
						 ->get('/api/v1/admin/clients?per_page=9999')
						 ->assertStatus(200);

		$data = [];
		foreach ($this->clients as $client) {
			$data[] = [
				'id'       => $client->id,
				'name'     => $client->name,
				'email'    => $client->email,
				'address'  => $client->address,
				'suburb'   => $client->suburb,
				'postcode' => $client->postcode,
				'state'    => $client->state,
			];
		}

		$response->assertJsonFragment(['data' => $data]);
	}

	// FitterAdmin should be able to search client
	public function testIndexSearch()
	{
		// Should be able to search client
		$response = $this->actingAs($this->admin, 'api')
						 ->get('/api/v1/admin/clients?per_page=9999&search=' . $this->clients[1]->name)
						 ->assertStatus(200)
						 ->assertSeeText($this->clients[1]->email)
						 ->assertDontSeeText($this->clients[0]->email);
	}

	// FitterAdmin should be able to get details of one of his client
	public function testGet()
	{
		$client = $this->clients[0];

		$horses = factory(\App\Horse::class, 5)->create([
			'client_id' => $client->id,
		]);

		$riders = factory(\App\Rider::class, 5)->create([
			'client_id' => $client->id,
		]);

		$users = factory(\App\User::class, 5)->create([
			'client_id' => $client->id,
			'type'      => 'user',
		]);

		factory(\App\Saddle::class, 5)->create([
			'horse_id' => $horses[0]->id,
			'rider_id' => $riders[0]->id,
		]);

		$response = $this->actingAs($this->admin, 'api')
						 ->get('/api/v1/admin/clients/' . $client->id)
						 ->assertStatus(200);

		// This data should be returned
		$horses = [];
		$riders = [];
		$saddles = [];
		$users = [];

		foreach ($client->horses as $horse) {
			$horses[] = [
				'id'              => $horse->id,
				'stable_name'     => $horse->stable_name,
				'breeding_name'   => $horse->breeding_name,
				'paddock_address' => $horse->paddock_address,
				'breed'           => $horse->breed,
				'colour'          => $horse->colour,
				'height'          => $horse->height,
				'weight'          => $horse->weight,
				'girth'           => $horse->girth,
				'length'          => $horse->length,
				'age'             => $horse->age,
				'dob'             => $horse->dob->format('d/m/Y'),
				'discipline'      => $horse->discipline,
				'sex'             => $horse->sex,
				'photo'           => $horse->photo,
				'created_at'      => $horse->created_at->format('d/m/Y'),
				'updated_at'      => $horse->updated_at->format('d/m/Y'),
			];
		}

		foreach ($client->riders as $rider) {
			$riders[] = [
				'id'                        => $rider->id,
				'first_name'                => $rider->first_name,
				'last_name'                 => $rider->last_name,
				'address'                   => $rider->address,
				'mobile'                    => $rider->mobile,
				'email'                     => $rider->email,
				'discipline'                => $rider->discipline,
				'stirrup_size'              => $rider->stirrup_size,
				'stirrup_leahter'           => $rider->stirrup_leahter,
				'height'                    => $rider->height,
				'jodphur_size'              => $rider->jodphur_size,
				'is_vip_member'             => $rider->is_vip_member,
				'award_points'              => $rider->award_points,
				'has_registered_on_website' => $rider->has_registered_on_website,
				'created_at'                => $rider->created_at->format('d/m/Y'),
				'updated_at'                => $rider->updated_at->format('d/m/Y'),
			];
		}

		foreach ($client->saddles as $saddle) {
			$saddles[] = [
				'id'            => $saddle->id,
				'brand_name'    => $saddle->brand->name,
				'model'         => $saddle->model,
				'serial_number' => $saddle->serial_number,
				'rider'         => $saddle->rider->getFullName(),
				'horse_name'    => $saddle->horse->stable_name,
				'created_at'    => $saddle->created_at->format('d/m/Y'),
				'updated_at'    => $saddle->updated_at->format('d/m/Y'),
			];
		}

		foreach ($client->users as $user) {
			$users[] = [
				'id'         => $user->id,
				'first_name' => $user->first_name,
				'last_name'  => $user->last_name,
				'status'     => $user->invitation ? 'Invited' : 'Active',
				'email'      => $user->email,
			];
		}

		$data = [
			'client'  => [
				'id'       => $client->id,
				'name'     => $client->name,
				'email'    => $client->email,
				'address'  => $client->address,
				'suburb'   => $client->suburb,
				'postcode' => $client->postcode,
				'state'    => $client->state,
			],
			'horses'  => $horses,
			'riders'  => $riders,
			'saddles' => $saddles,
			'users'   => $users,
		];

		$response->assertJson($data);
	}

	// FitterAdmin should be able to get create a client
	public function testPost()
	{
		$data = [
			'name'     => 'TestClient',
			'email'    => 'testclientcreated@com.com',
			'address'  => 'TestAddress',
			'suburb'   => 'QWERY',
			'postcode' => '1234',
			'state'    => 'ACT',
		];

		$this->actingAs($this->admin, 'api')
			 ->post('/api/v1/admin/clients', $data)
			 ->assertJsonStructure([
				 'success', 'id',
			 ])
			 ->assertStatus(200);

		$this->assertDatabaseHas('clients', $data);
	}

	// FitterAdmin should be able to update a client
	public function testPut()
	{
		$client = $this->clients[0];

		$data = [
			'name'     => 'TestClientedited',
			'email'    => 'testclientcreatededited@com.com',
			'address'  => 'TestAddressedited',
			'suburb'   => 'POIU',
			'postcode' => '4321',
			'state'    => 'QLD',
		];

		$this->actingAs($this->admin, 'api')
			 ->put('/api/v1/admin/clients/' . $client->id, $data)
			 ->assertJsonStructure([
				 'success', 'id',
			 ])
			 ->assertStatus(200);

		$this->assertDatabaseHas('clients', $data);
	}

	// FitterAdmin should be able to delete a client
	public function testDelete()
	{
		$client = $this->clients[0];

		$this->assertDatabaseHas('clients', ['email' => $client->email]);

		$this->actingAs($this->admin, 'api')
			 ->delete('/api/v1/admin/clients/' . $client->id)
			 ->assertStatus(200)
			 ->assertJsonStructure(['success']);

		$this->assertDatabaseMissing('clients', ['email' => $client->email]);
	}

	// FitterAdmin should not be able to delete a client with related data
	public function testDeleteFail()
	{
		// Client can not be delete when he has related horse or rider or saddle or user
		$client = $this->clients[1];
		$horses = factory(\App\Horse::class, 5)->create([
			'client_id' => $client->id,
		]);

		$riders = factory(\App\Rider::class, 5)->create([
			'client_id' => $client->id,
		]);

		$users = factory(\App\User::class, 5)->create([
			'client_id' => $client->id,
			'type'      => 'user',
		]);

		factory(\App\Saddle::class, 5)->create([
			'horse_id' => $horses[0]->id,
			'rider_id' => $riders[0]->id,
		]);

		$booking = factory(\App\Booking::class)->create([
			'fitter_id' => $this->admin->fitter->id,
			'client_id' => $client->id,
			'horse_id'  => factory(\App\Horse::class)->create(['client_id' => $client->id])->id,
			'rider_id'  => factory(\App\Rider::class)->create(['client_id' => $client->id])->id,
			'user_id'   => factory(\App\User::class)->create([
				'fitter_id' => $this->admin->fitter->id,
				'type'      => 'fitter-user',
			])->id,
		]);

		$this->actingAs($this->admin, 'api')
			 ->delete('/api/v1/admin/clients/' . $client->id)
			 ->assertStatus(422);

		$this->assertDatabaseHas('clients', ['email' => $client->email]);
	}

	// FitterAdmin should be able to invite user of client
	public function testPostInviteUser()
	{
		$client = $this->clients[0];

		$user_data = [
			'first_name' => 'TestClientUserInvited1',
			'last_name'  => 'TestClientUserInvited2',
			'email'      => 'testclientuserinvited@com.com',
		];

		Mail::fake();

		$this->actingAs($this->admin, 'api')
			 ->post('/api/v1/admin/clients/' . $client->id . '/invite-user', $user_data)
			 ->assertStatus(200);

		$this->assertDatabaseHas('users', [
			'email'     => $user_data['email'],
			'client_id' => $client->id,
		]);
		$this->assertDatabaseHas('invitations', [
			'user_id' => \App\User::where('email', $user_data['email'])->first()->id,
		]);
	}

	// FitterAdmin should be able to create user of client
	public function testPostCreateUser()
	{
		$client = $this->clients[0];

		$user_data = [
			'first_name' => 'TestClientUserCreate1',
			'last_name'  => 'TestClientUserCreate2',
			'email'      => 'testclientuserCreate@com.com',
		];

		$this->actingAs($this->admin, 'api')
			 ->post('/api/v1/admin/clients/' . $client->id . '/create-user', array_merge($user_data, [
				 'password'              => 'tester',
				 'password_confirmation' => 'tester',
			 ]))
			 ->assertStatus(200)
			 ->assertJsonStructure(['success', 'id']);

		$this->assertDatabaseHas('users', [
			'email'     => $user_data['email'],
			'client_id' => $client->id,
		]);
	}

	// FitterAdmin should be able to edit user of client
	public function testPutUpdateUser()
	{
		$client = $this->clients[0];

		$user_data = [
			'first_name' => 'TestClientUserUpdated1',
			'last_name'  => 'TestClientUserUpdated2',
			'email'      => 'testclientuserUpdated@com.com',
		];

		// Add a user to this client
		$user = factory(\App\User::class)->create([
			'client_id' => $client->id,
			'type'      => 'user',
			'email'     => 'testclientuser@com.com',
		]);

		// update
		$this->actingAs($this->admin, 'api')
			 ->put('/api/v1/admin/clients/' . $client->id . '/put-user/' . $user->id, array_merge($user_data, [
				 'password'              => 'newpassword',
				 'password_confirmation' => 'newpassword',
			 ]))
			 ->assertStatus(200)
			 ->assertJsonStructure(['success', 'id']);

		$this->assertDatabaseHas('users', $user_data);
	}

	// FitterAdmin should be able to delete user of client
	public function testDeleteUser()
	{
		$client = $this->clients[0];

		// Add a user to this client
		$user = factory(\App\User::class)->create([
			'client_id' => $client->id,
			'type'      => 'user',
			'email'     => 'testclientuser@com.com',
		]);

		$this->assertDatabaseHas('users', $user->toArray());

		// delete
		$this->actingAs($this->admin, 'api')
			 ->delete('/api/v1/admin/clients/' . $client->id . '/delete-user/' . $user->id)
			 ->assertStatus(200)
			 ->assertJsonStructure(['success']);

		$this->assertDatabaseMissing('users', $user->toArray());
	}

	// FitterAdmin should be able to get user of client
	public function testGetUser()
	{
		$client = $this->clients[0];

		// Add a user to this client
		$user = factory(\App\User::class)->create([
			'client_id' => $client->id,
			'type'      => 'user',
			'email'     => 'testclientuser@com.com',
		]);

		// get
		$response = $this->actingAs($this->admin, 'api')
						 ->get('/api/v1/admin/clients/' . $client->id . '/get-user/' . $user->id)
						 ->assertStatus(200);

		$response->assertJsonFragment([
			'first_name' => $user->first_name,
			'last_name'  => $user->last_name,
			'email'      => $user->email,
			'client_id'  => $user->client_id,
		]);
	}

}
