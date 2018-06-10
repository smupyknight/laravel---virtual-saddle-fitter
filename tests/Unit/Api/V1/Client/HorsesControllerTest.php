<?php

namespace Tests\Unit\Api\V1\Client;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class HorsesControllerTest extends TestCase
{

	// Client User
	private $clientUser;
	private $admin;
	private $client;
	private $horses;

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
		$this->client = factory(\App\Client::class)->create();

		factory(\App\ClientFitter::class)->create([
			'client_id' => $this->client->id,
			'fitter_id' => $this->admin->fitter->id,
		]);

		// Add acting user
		$this->clientUser = factory(\App\User::class)->create([
			'client_id' => $this->client->id,
			'type'      => 'user',
		]);

		$this->horses = factory(\App\Horse::class, 5)->create([
			'client_id' => $this->client->id,
		]);
	}

	// Client's user should be able to get list of horses
	public function testIndex()
	{
		$data = [];

		foreach ($this->horses as $horse) {
			$data[] = [
				'id'            => $horse->id,
				'stable_name'   => $horse->stable_name,
				'breeding_name' => $horse->breeding_name,
				'breed'         => $horse->breed,
				'colour'        => $horse->colour,
				'discipline'    => $horse->discipline,
				'age'           => $horse->age,
				'sex'           => $horse->sex,
			];
		}

		$this->actingAs($this->clientUser, 'api')
			 ->get('/api/v1/client/horses?per_page=9999')
			 ->assertStatus(200)
			 ->assertJsonFragment(['data' => $data]);
	}

	// Client's user should be able to get details of a horse
	public function testGetView()
	{
		$horse = $this->horses[0];

		$riders = $horse->riders()->select('id', 'first_name', 'last_name', 'mobile', 'email')->get();

		$saddles = [];

		foreach ($horse->saddles as $saddle) {
			$saddles[] = [
				'id'    => $saddle->id,
				'name'  => $saddle->name,
				'brand' => [
					'id'   => $saddle->style->brand->id,
					'name' => $saddle->style->brand->name,
				],
				'style' => [
					'id'   => $saddle->style->id,
					'name' => $saddle->style->name,
				],
				'type'  => $saddle->type,
			];
		}

		$data = [
			'id'               => $horse->id,
			'stable_name'      => $horse->stable_name,
			'breeding_name'    => $horse->breeding_name,
			'paddock_address'  => $horse->paddock_address,
			'postcode'         => $horse->postcode,
			'state'            => $horse->state,
			'suburb'           => $horse->suburb,
			'breed'            => $horse->breed,
			'colour'           => $horse->colour,
			'height'           => $horse->height,
			'weight'           => $horse->weight,
			'girth'            => $horse->girth,
			'age'              => $horse->age,
			'dob'              => $horse->dob->format('d/m/Y'),
			'discipline'       => $horse->discipline,
			'sex'              => $horse->sex,
			'photo'            => $horse->photo,
			'microchip_number' => $horse->microchip_number,
			'created_at'       => $horse->created_at->format('d/m/Y'),
			'updated_at'       => $horse->updated_at->format('d/m/Y'),
			'riders'           => $riders,
			'saddles'          => $saddles,
		];

		$this->actingAs($this->clientUser, 'api')
			 ->get('/api/v1/client/horses/' . $horse->id)
			 ->assertStatus(200)
			 ->assertJson(json_decode(json_encode($data), true));
	}

	// Client's user should be able to create a horse
	public function testPostCreate()
	{
		$data = [
			'stable_name'      => 'TestStable',
			'breeding_name'    => 'TestBreeding',
			'paddock_address'  => 'TestAddress',
			'postcode'         => '1234',
			'state'            => 'QLD',
			'suburb'           => 'FakeVile',
			'breed'            => factory(\App\Breed::class)->create()->name,
			'height'           => '123',
			'weight'           => '234',
			'girth'            => '345',
			'colour'           => 'Grey',
			'age'              => '23',
			'dob'              => '11/12/2015',
			'discipline'       => 'Sporting',
			'sex'              => 'Stallion',
			'photo'            => '',
			'microchip_number' => 'TestChip',
		];

		$this->actingAs($this->clientUser, 'api')
			 ->post('/api/v1/client/horses', $data)
			 ->assertStatus(200)
			 ->assertJsonStructure([
				 'success',
				 'id',
			 ]);

		$this->assertDatabaseHas('horses', ['stable_name' => $data['stable_name']]);
	}

	// Client's user should be able to update a horse
	public function testPut()
	{
		$data = [
			'stable_name'      => 'TestStable2',
			'breeding_name'    => 'TestBreeding2',
			'paddock_address'  => 'TestAddress2',
			'postcode'         => '1223',
			'state'            => 'NSW',
			'suburb'           => 'FakeVille',
			'breed'            => factory(\App\Breed::class)->create()->name,
			'height'           => '223',
			'weight'           => '234',
			'girth'            => '245',
			'colour'           => 'blood bay',
			'age'              => '13',
			'dob'              => '11/12/2005',
			'discipline'       => 'Racing',
			'sex'              => 'Stallion',
			'photo'            => '',
			'microchip_number' => 'TestChip2',
		];

		$horse = $this->horses[0];

		$this->actingAs($this->clientUser, 'api')
			 ->put('/api/v1/client/horses/' . $horse->id, $data)
			 ->assertStatus(200)
			 ->assertJsonStructure([
				 'success',
				 'id',
			 ]);

		$this->assertDatabaseHas('horses', ['stable_name' => $data['stable_name']]);
	}

	// Client's user should be able to delete a horse
	public function testDelete()
	{
		$horse = $this->horses[0];

		$this->actingAs($this->clientUser, 'api')
			 ->delete('/api/v1/client/horses/' . $horse->id)
			 ->assertStatus(200);

		$this->assertDatabaseMissing('horses', ['id' => $horse->id]);
	}

}
