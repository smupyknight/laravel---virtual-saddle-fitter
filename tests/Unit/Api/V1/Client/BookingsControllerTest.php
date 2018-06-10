<?php

namespace Tests\Unit\Api\V1\Client;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BookingsControllerTest extends TestCase
{

	// Client, Bookings, ...
	private $clientUser;
	private $client;
	private $fitters;
	private $bookings = [];

	// Prepare Tests
	public function setUp()
	{
		parent::setUp();

		// Add client
		$this->client = factory(\App\Client::class)->create();

		// Add fitters
		$this->fitters = factory(\App\Fitter::class, 5)->create();

		foreach ($this->fitters as $fitter) {
			factory(\App\ClientFitter::class)->create([
				'client_id' => $this->client->id,
				'fitter_id' => $fitter->id,
			]);
		}

		// Add acting user
		$this->clientUser = factory(\App\User::class)->create([
			'client_id' => $this->client->id,
			'type'      => 'user',
		]);

		// Add bookings
		foreach ($this->fitters as $fitter) {
			$booking = factory(\App\Booking::class)->create([
				'fitter_id' => $fitter->id,
				'client_id' => $this->client->id,
				'horse_id'  => factory(\App\Horse::class)->create(['client_id' => $this->client->id])->id,
				'rider_id'  => factory(\App\Rider::class)->create(['client_id' => $this->client->id])->id,
				'user_id'   => factory(\App\User::class)->create([
					'fitter_id' => $fitter->id,
					'type'      => 'fitter-user',
				])->id,
			]);

			$this->bookings[] = $booking;
		}
	}

	// Client's user should be able to get a list of bookings
	public function testIndex()
	{
		// Add test bookings
		$bookings = [];
		foreach ($this->bookings as $booking) {
			$bookings[] = $booking->toArray();
		}

		$response = $this->actingAs($this->clientUser, 'api')
						 ->get('/api/v1/client/bookings?per_page=9999')
						 ->assertStatus(200);

		$data = [];
		foreach ($this->bookings as $booking) {
			$data[] = [
				'id'         => $booking->id,
				'fitter'     => [
					'id'   => $booking->fitter ? $booking->fitter->id : '',
					'name' => $booking->fitter ? $booking->fitter->name : '',
				],
				'user'       => [
					'id'         => $booking->user ? $booking->user->id : '',
					'first_name' => $booking->user ? $booking->user->first_name : '',
					'last_name'  => $booking->user ? $booking->user->last_name : '',
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
				'saddle'     => [
					'id'   => $booking->saddle ? $booking->saddle->id : '',
					'name' => $booking->saddle ? $booking->saddle->name : '',
				],
				'date'       => $booking->date->format('d/m/Y'),
				'address'    => $booking->address,
				'created_at' => $booking->created_at->format('d/m/Y'),
				'updated_at' => $booking->updated_at->format('d/m/Y'),
			];
		}

		$response->assertJsonFragment(['data' => $data]);
	}

	// Client's user should be able to create a booking
	public function testPost()
	{
		$data = [
			'fitter_id' => $this->fitters[0]->id,
			'horse_id'  => factory(\App\Horse::class)->create(['client_id' => $this->client->id])->id,
			'rider_id'  => factory(\App\Rider::class)->create(['client_id' => $this->client->id])->id,
			'saddle_id' => '',
			'date'      => \Carbon\Carbon::tomorrow()->format('d/m/Y'),
			'address'   => 'Test Address',
		];

		$this->actingAs($this->clientUser, 'api')
			 ->post('/api/v1/client/bookings', $data)
			 ->assertStatus(200)
			 ->assertJsonStructure([
				 'success', 'id',
			 ]);

		$this->assertDatabaseHas('bookings', [
			'client_id' => $this->client->id,
			'horse_id'  => $data['horse_id'],
			'rider_id'  => $data['rider_id'],
		]);
	}

	// Client's user should be able to get details of a booking
	public function testGet()
	{
		$booking = $this->bookings[0];

		$this->actingAs($this->clientUser, 'api')
			 ->get('/api/v1/client/bookings/' . $booking->id)
			 ->assertStatus(200)
			 ->assertJson([
				 'id'         => $booking->id,
				 'fitter'     => [
					 'id'   => $booking->fitter ? $booking->fitter->id : '',
					 'name' => $booking->fitter ? $booking->fitter->name : '',
				 ],
				 'user'       => [
					 'id'         => $booking->user ? $booking->user->id : '',
					 'first_name' => $booking->user ? $booking->user->first_name : '',
					 'last_name'  => $booking->user ? $booking->user->last_name : '',
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

	// Client's user should be able to update details of a booking
	public function testPut()
	{
		$booking = $this->bookings[0];

		$data = [
			'fitter_id' => $this->fitters[0]->id,
			'horse_id'  => factory(\App\Horse::class)->create(['client_id' => $this->client->id])->id,
			'rider_id'  => factory(\App\Rider::class)->create(['client_id' => $this->client->id])->id,
			'saddle_id' => '',
			'date'      => \Carbon\Carbon::tomorrow()->format('d/m/Y'),
			'address'   => 'Test Address',
		];

		$this->actingAs($this->clientUser, 'api')
			 ->put('/api/v1/client/bookings/' . $booking->id, $data)
			 ->assertStatus(200)
			 ->assertJsonStructure([
				 'success', 'id',
			 ]);

		$this->assertDatabaseHas('bookings', [
			'client_id' => $this->client->id,
			'horse_id'  => $data['horse_id'],
			'rider_id'  => $data['rider_id'],
		]);
	}

	// Client's user should be able to delete a booking
	public function testDelete()
	{
		$booking = $this->bookings[0];

		$this->actingAs($this->clientUser, 'api')
			 ->delete('/api/v1/client/bookings/' . $booking->id)
			 ->assertStatus(200)
			 ->assertJsonStructure([
				 'success',
			 ]);

		$this->assertDatabaseMissing('bookings', ['id' => $booking->id]);
	}

}
