<?php

namespace Tests\Unit\Api\V1\Admin;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SaddlesControllerTest extends TestCase
{

	// FitterAdmin User
	private $admin;
	private $client;
	private $horses;
	private $riders;
	private $saddles;
	private $styles;

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

		$this->horses = factory(\App\Horse::class, 5)->create([
			'client_id' => $this->client->id,
		]);

		$this->styles = factory(\App\Style::class, 5)->create();

		$this->saddles = factory(\App\Saddle::class, 5)->create([
			'horse_id' => $this->horses[0]->id,
			'rider_id' => $this->riders[0]->id,
		]);
	}

	// FitterAdmin should be able to get list of saddles
	public function testIndex()
	{
		$data = [];

		foreach ($this->saddles as $saddle) {
			$data[] = [
				'id'            => $saddle->id,
				'name'          => $saddle->name,
				'horse'         => [
					'id'          => $saddle->horse->id,
					'stable_name' => $saddle->horse->stable_name,
				],
				'brand'         => [
					'id'   => $saddle->brand->id,
					'name' => $saddle->brand->name,
				],
				'style'         => [
					'id'   => $saddle->style->id,
					'name' => $saddle->style->name,
				],
				'type'          => $saddle->type,
				'serial_number' => $saddle->serial_number,
				'created_at'    => $saddle->created_at->format('d/m/Y'),
			];
		}

		$this->actingAs($this->admin, 'api')
			 ->get('/api/v1/admin/saddles?per_page=9999')
			 ->assertStatus(200)
			 ->assertJson(['data' => $data]);
	}

	// FitterAdmin should be able to get details of a saddle
	public function testGet()
	{
		$saddle = $this->saddles[0];

		$data_array = $saddle->toArray();
		$data_array['purchased_at'] = $saddle->purchased_at ? $saddle->purchased_at->format('d/m/Y') : '';
		$data_array['rider'] = [
			'id'         => $saddle->rider ? $saddle->rider->id : '',
			'first_name' => $saddle->rider ? $saddle->rider->first_name : '',
			'last_name'  => $saddle->rider ? $saddle->rider->last_name : '',
		];
		$data_array['horse'] = [
			'id'          => $saddle->horse ? $saddle->horse->id : '',
			'stable_name' => $saddle->horse ? $saddle->horse->stable_name : '',
		];
		$data_array['brand'] = [
			'id'   => $saddle->brand ? $saddle->brand->id : '',
			'name' => $saddle->brand ? $saddle->brand->name : '',
		];
		$data_array['style'] = [
			'id'   => $saddle->style ? $saddle->style->id : '',
			'name' => $saddle->style ? $saddle->style->name : '',
		];

		$this->actingAs($this->admin, 'api')
			 ->get('/api/v1/admin/saddles/' . $saddle->id)
			 ->assertStatus(200)
			 ->assertJson(json_decode(json_encode($data_array), true));
	}

	// FitterAdmin should be able to create a saddle
	public function testPost()
	{
		$rider = $this->riders[0];
		$horse = $this->horses[0];

		$data = [
			'rider_id'        => $rider->id,
			'horse_id'        => $horse->id,
			'brand_id'        => $this->styles[0]->brand->id,
			'style_id'        => $this->styles[0]->id,
			'name'            => 'TestSaddle',
			'price'           => '100',
			'serial_number'   => '1234',
			'size'            => '234',
			'type'            => 'All Purpose',
			'gullet_size'     => 'n',
			'panel_type'      => 'Flock',
			'seat_style'      => 'Deep seat',
			'purchased_at'    => '11/11/2015',
			'warranty_period' => '5',
		];

		$this->actingAs($this->admin, 'api')
			 ->post('/api/v1/admin/saddles', $data)
			 ->assertStatus(200)
			 ->assertJsonStructure([
				 'id',
			 ]);

		$this->assertDatabaseHas('saddles', ['name' => $data['name']]);
	}

	// FitterAdmin should be able to update a saddle
	public function testPut()
	{
		$rider = $this->riders[0];
		$horse = $this->horses[0];

		$data = [
			'rider_id'        => $rider->id,
			'horse_id'        => $horse->id,
			'brand_id'        => $this->styles[0]->brand->id,
			'style_id'        => $this->styles[0]->id,
			'name'            => 'TestSaddle',
			'price'           => '100',
			'serial_number'   => '1234',
			'size'            => '234',
			'type'            => 'All Purpose',
			'gullet_size'     => 'n',
			'panel_type'      => 'Flock',
			'seat_style'      => 'Deep seat',
			'purchased_at'    => '11/11/2015',
			'warranty_period' => '5',
		];

		$saddle = $this->saddles[0];

		$this->actingAs($this->admin, 'api')
			 ->put('/api/v1/admin/saddles/' . $saddle->id, $data)
			 ->assertStatus(200)
			 ->assertJsonStructure([
				 'id',
			 ]);

		$this->assertDatabaseHas('saddles', ['name' => $data['name']]);
	}

	// FitterAdmin should be able to delete a saddle
	public function testDelete()
	{
		$saddle = $this->saddles[0];

		$this->actingAs($this->admin, 'api')
			 ->delete('/api/v1/admin/saddles/' . $saddle->id)
			 ->assertStatus(200);

		$this->assertDatabaseMissing('saddles', ['id' => $saddle->id]);
	}

}
