<?php

namespace Tests\Unit\Api\V1\Admin;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BookingsControllerTest extends TestCase
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

	// FitterAdmin should be able to get list of bookings of his clients
	public function testIndex()
	{
		// Add test bookings
		foreach ($this->clients as $client) {
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
		}

		$bookings = [];
		$bookings_upcoming = \App\Booking::all();

		foreach ($bookings_upcoming as $booking) {
			$bookings[] = $booking->toArray();
		}

		$response = $this->actingAs($this->admin, 'api')
						 ->get('/api/v1/admin/bookings?per_page=8888')
						 ->assertStatus(200);

		$data = [];
		foreach ($bookings as $item) {
			$booking = \App\Booking::find($item['id']);
			$data[] = [
				'id'         => $booking->id,
				'client'     => [
					'id'   => $booking->client->id,
					'name' => $booking->client->name,
				],
				'horse'      => [
					'id'          => $booking->horse->id,
					'stable_name' => $booking->horse->stable_name,
				],
				'rider'      => [
					'id'         => $booking->rider->id,
					'first_name' => $booking->rider->first_name,
					'last_name'  => $booking->rider->last_name,
				],
				'date'       => $booking->date->format('d/m/Y'),
				'created_at' => $booking->created_at->format('d/m/Y'),
				'updated_at' => $booking->updated_at->format('d/m/Y'),
			];
		}

		$response->assertJsonFragment(['data' => $data]);
	}

	public function testIndexCompleted()
	{
		// Add test bookings
		foreach ($this->clients as $client) {
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
		}

		$bookings = [];
		$bookings_upcoming = \App\Booking::where('date', '<', \Carbon\Carbon::now())->get();

		foreach ($bookings_upcoming as $booking) {
			$bookings[] = $booking->toArray();
		}

		$response = $this->actingAs($this->admin, 'api')
						 ->get('/api/v1/admin/bookings?per_page=8888&booking_status=completed')
						 ->assertStatus(200);

		$data = [];
		foreach ($bookings as $item) {
			$booking = \App\Booking::find($item['id']);
			$data[] = [
				'id'         => $booking->id,
				'client'     => [
					'id'   => $booking->client->id,
					'name' => $booking->client->name,
				],
				'horse'      => [
					'id'          => $booking->horse->id,
					'stable_name' => $booking->horse->stable_name,
				],
				'rider'      => [
					'id'         => $booking->rider->id,
					'first_name' => $booking->rider->first_name,
					'last_name'  => $booking->rider->last_name,
				],
				'date'       => $booking->date->format('d/m/Y'),
				'created_at' => $booking->created_at->format('d/m/Y'),
				'updated_at' => $booking->updated_at->format('d/m/Y'),
			];
		}

		$response->assertJsonFragment(['data' => $data]);
	}

	public function testIndexUpcoming()
	{
		// Add test bookings
		foreach ($this->clients as $client) {
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
		}

		$bookings = [];
		$bookings_upcoming = \App\Booking::where('date', '>', \Carbon\Carbon::now())->get();

		foreach ($bookings_upcoming as $booking) {
			$bookings[] = $booking->toArray();
		}

		$response = $this->actingAs($this->admin, 'api')
						 ->get('/api/v1/admin/bookings?per_page=8888&booking_status=upcoming')
						 ->assertStatus(200);

		$data = [];
		foreach ($bookings as $item) {
			$booking = \App\Booking::find($item['id']);
			$data[] = [
				'id'         => $booking->id,
				'client'     => [
					'id'   => $booking->client->id,
					'name' => $booking->client->name,
				],
				'horse'      => [
					'id'          => $booking->horse->id,
					'stable_name' => $booking->horse->stable_name,
				],
				'rider'      => [
					'id'         => $booking->rider->id,
					'first_name' => $booking->rider->first_name,
					'last_name'  => $booking->rider->last_name,
				],
				'date'       => $booking->date->format('d/m/Y'),
				'created_at' => $booking->created_at->format('d/m/Y'),
				'updated_at' => $booking->updated_at->format('d/m/Y'),
			];
		}

		$response->assertJsonFragment(['data' => $data]);
	}

	// FitterAdmin should be able to get one booking details
	public function testGet()
	{
		// Add test bookings
		$bookings = [];
		foreach ($this->clients as $client) {
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

			$bookings[] = $booking->toArray();
		}

		$booking = \App\Booking::find($bookings[0]['id']);

		$this->actingAs($this->admin, 'api')
			 ->get('/api/v1/admin/bookings/' . $booking->id)
			 ->assertStatus(200)
			 ->assertJson([
				 'id'         => $booking->id,
				 'client'     => [
					 'id'   => $booking->client->id,
					 'name' => $booking->client->name,
				 ],
				 'horse'      => [
					 'id'          => $booking->horse->id,
					 'stable_name' => $booking->horse->stable_name,
				 ],
				 'rider'      => [
					 'id'         => $booking->rider->id,
					 'first_name' => $booking->rider->first_name,
					 'last_name'  => $booking->rider->last_name,
				 ],
				 'user'       => [
					 'id'         => $booking->user ? $booking->user->id : '',
					 'first_name' => $booking->user ? $booking->user->first_name : '',
					 'last_name'  => $booking->user ? $booking->user->last_name : '',
				 ],
				 'saddle'     => [
					 'id'   => $booking->saddle ? $booking->saddle->id : '',
					 'name' => $booking->saddle ? $booking->saddle->name : '',
				 ],
				 'date'       => $booking->date->format('d/m/Y'),
				 'address'    => $booking->address,
				 'created_at' => $booking->created_at->format('d/m/Y'),
				 'updated_at' => $booking->updated_at->format('d/m/Y'),
			 ]);
	}

	// FitterAdmin should be able to create new booking
	public function testPost()
	{
		$client = $this->clients[0];
		$data = [
			'client_id' => $client->id,
			'horse_id'  => factory(\App\Horse::class)->create(['client_id' => $client->id])->id,
			'rider_id'  => factory(\App\Rider::class)->create(['client_id' => $client->id])->id,
			'user_id'   => factory(\App\User::class)->create([
				'fitter_id' => $this->admin->fitter->id,
				'type'      => 'fitter-user',
			])->id,
			'saddle_id' => '',
			'date'      => \Carbon\Carbon::tomorrow()->format('d/m/Y'),
			'address'   => 'Test Address',
		];

		$this->actingAs($this->admin, 'api')
			 ->post('/api/v1/admin/bookings', $data)
			 ->assertStatus(200)
			 ->assertJsonStructure([
				 'success', 'id',
			 ]);

		$this->assertDatabaseHas('bookings', [
			'client_id' => $data['client_id'],
			'horse_id'  => $data['horse_id'],
			'rider_id'  => $data['rider_id'],
			'user_id'   => $data['user_id'],
		]);
	}

	// FitterAdmin should be able to update a booking
	public function testPut()
	{
		// Add test bookings
		$bookings = [];
		foreach ($this->clients as $client) {
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

			$bookings[] = $booking->toArray();
		}

		$booking = \App\Booking::find($bookings[0]['id']);

		$client = $this->clients[0];

		$data = [
			'client_id' => $client->id,
			'horse_id'  => factory(\App\Horse::class)->create(['client_id' => $client->id])->id,
			'rider_id'  => factory(\App\Rider::class)->create(['client_id' => $client->id])->id,
			'user_id'   => factory(\App\User::class)->create([
				'fitter_id' => $this->admin->fitter->id,
				'type'      => 'fitter-user',
			])->id,
			'saddle_id' => '',
			'date'      => \Carbon\Carbon::tomorrow()->format('d/m/Y'),
			'address'   => 'Test Address',
		];

		$this->actingAs($this->admin, 'api')
			 ->put('/api/v1/admin/bookings/' . $booking->id, $data)
			 ->assertStatus(200)
			 ->assertJsonStructure([
				 'success', 'id',
			 ]);

		$this->assertDatabaseHas('bookings', [
			'client_id' => $data['client_id'],
			'horse_id'  => $data['horse_id'],
			'rider_id'  => $data['rider_id'],
			'user_id'   => $data['user_id'],
		]);
	}

	// FitterAdmin should be able to delete a booking
	public function testDelete()
	{
		// Add test bookings
		$bookings = [];
		foreach ($this->clients as $client) {
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

			$bookings[] = $booking->toArray();
		}

		$booking = \App\Booking::find($bookings[0]['id']);

		$this->actingAs($this->admin, 'api')
			 ->delete('/api/v1/admin/bookings/' . $booking->id)
			 ->assertStatus(200)
			 ->assertJsonStructure([
				 'success',
			 ]);

		$this->assertDatabaseMissing('bookings', ['id' => $booking->id]);
	}

}
