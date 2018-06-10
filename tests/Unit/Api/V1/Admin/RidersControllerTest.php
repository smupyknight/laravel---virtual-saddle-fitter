<?php

namespace Tests\Unit\Api\V1\Admin;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RidersControllerTest extends TestCase
{

	// FitterAdmin User
	private $admin;
	private $client;
	private $riders;

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

		$this->riders = factory(\App\Rider::class, 5)->create([
			'client_id' => $this->client->id,
		]);
	}

	// FitterAdmin should be able to get list of riders
	public function testIndex()
	{
		$data = [];

		foreach ($this->riders as $rider) {
			$data[] = [
				'address'                   => $rider->address,
				'award_points'              => $rider->award_points,
				'client_id'                 => $rider->client_id,
				'created_at'                => $rider->created_at->format('Y-m-d H:i:s'),
				'discipline'                => $rider->discipline,
				'email'                     => $rider->email,
				'first_name'                => $rider->first_name,
				'has_registered_on_website' => $rider->has_registered_on_website,
				'height'                    => $rider->height,
				'id'                        => $rider->id,
				'is_vip_member'             => $rider->is_vip_member,
				'jodphur_size'              => $rider->jodphur_size,
				'last_name'                 => $rider->last_name,
				'mobile'                    => $rider->mobile,
				'postcode'                  => $rider->postcode,
				'state'                     => $rider->state,
				'stirrup_leather'           => $rider->stirrup_leather,
				'stirrup_size'              => $rider->stirrup_size,
				'suburb'                    => $rider->suburb,
				'updated_at'                => $rider->updated_at->format('Y-m-d H:i:s'),
			];
		}

		$this->actingAs($this->admin, 'api')
			 ->get('/api/v1/admin/riders?per_page=9999')
			 ->assertStatus(200)
			 ->assertJson(['data' => $data]);
	}

	// FitterAdmin should be able to get details of a rider
	public function testGet()
	{
		$rider = $this->riders[0];

		$client = \App\Client::findOrFail($rider->client_id);

		$horses = factory(\App\Horse::class, 5)->create([
			'client_id' => $client->id,
		]);

		$horses = [];
		$fitters = [];
		foreach ($rider->horses as $horse) {
			$horses[] = [
				'id'              => $horse->id,
				'client_id'       => $horse->client_id,
				'stable_name'     => $horse->stable_name,
				'breeding_name'   => $horse->breeding_name,
				'paddock_address' => $horse->paddock_address,
				'postcode'        => $horse->postcode,
				'state'           => $horse->state,
				'suburb'          => $horse->suburb,
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

		foreach ($client->fitters as $fitter) {
			$fitters[] = [
				'id'         => $fitter->id,
				'name'       => $fitter->name,
				'abn'        => $fitter->abn,
				'phone'      => $fitter->phone,
				'email'      => $fitter->email,
				'address'    => $fitter->address,
				'suburb'     => $fitter->suburb,
				'postcode'   => $fitter->postcode,
				'state'      => $fitter->state,
				'logo'       => $fitter->logo,
				'created_at' => $fitter->created_at->format('d/m/Y'),
				'updated_at' => $fitter->updated_at->format('d/m/Y'),
			];
		}

		$data = [
			'rider'   => [
				'id'                        => $rider->id,
				'client_id'                 => $rider->client_id,
				'first_name'                => $rider->first_name,
				'last_name'                 => $rider->last_name,
				'address'                   => $rider->address,
				'postcode'                  => $rider->postcode,
				'state'                     => $rider->state,
				'suburb'                    => $rider->suburb,
				'mobile'                    => $rider->mobile,
				'email'                     => $rider->email,
				'discipline'                => $rider->discipline,
				'stirrup_size'              => (int) $rider->stirrup_size,
				'stirrup_leather'           => (int) $rider->stirrup_leather,
				'height'                    => (int) $rider->height,
				'jodphur_size'              => (int) $rider->jodphur_size,
				'is_vip_member'             => (bool) $rider->is_vip_member,
				'award_points'              => $rider->award_points,
				'has_registered_on_website' => (bool) $rider->has_registered_on_website,
				'created_at'                => $rider->created_at->format('d/m/Y'),
				'updated_at'                => $rider->updated_at->format('d/m/Y'),
			],
			'client'  => $client->toArray(),
			'horses'  => $horses,
			'fitters' => $fitters,
		];

		$this->actingAs($this->admin, 'api')
			 ->get('/api/v1/admin/riders/' . $rider->id)
			 ->assertStatus(200)
			 ->assertJson(json_decode(json_encode($data), true));
	}

	// FitterAdmin should be able to create a rider
	public function testPost()
	{
		$data = [
			'client_id'                 => $this->client->id,
			'first_name'                => 'TestFirstName1',
			'last_name'                 => 'TestLastName1',
			'address'                   => 'TestAddress1',
			'postcode'                  => '1234',
			'suburb'                    => '2345',
			'state'                     => 'QLD',
			'mobile'                    => '1234567890',
			'email'                     => 'testfirstemail@com.com',
			'discipline'                => 'Sporting',
			'stirrup_size'              => '12',
			'stirrup_leather'           => '23',
			'height'                    => '34',
			'jodphur_size'              => '45',
			'is_vip_member'             => false,
			'award_points'              => '0',
			'has_registered_on_website' => false,
		];

		$this->actingAs($this->admin, 'api')
			 ->post('/api/v1/admin/riders', $data)
			 ->assertStatus(200)
			 ->assertJsonStructure([
				 'success',
				 'id',
			 ]);

		$this->assertDatabaseHas('riders', ['first_name' => $data['first_name']]);
	}

	// FitterAdmin should be able to update a rider
	public function testPut()
	{
		$data = [
			'client_id'                 => $this->client->id,
			'first_name'                => 'TestFirstName2',
			'last_name'                 => 'TestLastName2',
			'address'                   => 'TestAddress2',
			'postcode'                  => '1234',
			'suburb'                    => '2345',
			'state'                     => 'QLD',
			'mobile'                    => '1234567890',
			'email'                     => 'testfirstemail@com.com',
			'discipline'                => 'Sporting',
			'stirrup_size'              => '12',
			'stirrup_leather'           => '23',
			'height'                    => '34',
			'jodphur_size'              => '45',
			'is_vip_member'             => false,
			'award_points'              => '0',
			'has_registered_on_website' => false,
		];

		$rider = $this->riders[0];

		$this->actingAs($this->admin, 'api')
			 ->put('/api/v1/admin/riders/' . $rider->id, $data)
			 ->assertStatus(200)
			 ->assertJsonStructure([
				 'success',
				 'id',
			 ]);

		$this->assertDatabaseHas('riders', ['first_name' => $data['first_name']]);
	}

	// FitterAdmin should be able to delete a rider
	public function testDelete()
	{
		$rider = $this->riders[0];

		$this->actingAs($this->admin, 'api')
			 ->delete('/api/v1/admin/riders/' . $rider->id)
			 ->assertStatus(200);

		$this->assertDatabaseMissing('riders', ['id' => $rider->id]);
	}

}
