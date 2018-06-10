<?php

namespace Tests\Unit\Api\V1\Client;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MyFittersControllerTest extends TestCase
{

	// Client User
	private $clientUser;
	private $client;
	private $fitters;
	private $fittersUnrelated;

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

		// Add some unrelated fitters
		$this->fittersUnrelated = factory(\App\Fitter::class, 5)->create();

		// Add acting user
		$this->clientUser = factory(\App\User::class)->create([
			'client_id' => $this->client->id,
			'type'      => 'user',
		]);
	}

	// Client's user should be able to get a list of his related fitters
	public function testIndex()
	{
		$this->client = $this->client->fresh();

		$data_related = $this->client->fitters->toArray();
		foreach ($data_related as $key => $datum) {
			$data_related[$key]['related'] = true;
		}

		$data_all = \App\Fitter::all()->toArray();
		foreach ($data_all as $key => $datum) {
			$data_all[$key]['related'] = (\App\ClientFitter::where('client_id', $this->client->id)
														   ->where('fitter_id', $datum['id'])
														   ->first()) ? true : false;
		}

		// Test get related
		$this->actingAs($this->clientUser, 'api')
			 ->get('/api/v1/client/my-fitters?related=true')
			 ->assertStatus(200)
			 ->assertJsonFragment(['data' => $data_related]);

		// Test get all
		$this->actingAs($this->clientUser, 'api')
			 ->get('/api/v1/client/my-fitters?related=false')
			 ->assertStatus(200)
			 ->assertJsonFragment(['data' => $data_all]);
	}

	// Client's user should be able to set unrelated fitter to be related
	public function testPost()
	{
		$fitter_unrelated = $this->fittersUnrelated[0];

		$this->assertDatabaseMissing('client_fitter', [
			'fitter_id' => $fitter_unrelated->id,
			'client_id' => $this->client->id,
		]);

		$this->actingAs($this->clientUser, 'api')
			 ->post('/api/v1/client/my-fitters/' . $fitter_unrelated->id)
			 ->assertStatus(200)
			 ->assertJson([
				 'success' => true,
			 ]);

		$this->assertDatabaseHas('client_fitter', [
			'fitter_id' => $fitter_unrelated->id,
			'client_id' => $this->client->id,
		]);
	}

	// Client's user should be able to set related fitter to be unrelated
	public function testDelete()
	{
		$fitter_related = $this->fitters[0];

		$this->assertDatabaseHas('client_fitter', [
			'fitter_id' => $fitter_related->id,
			'client_id' => $this->client->id,
		]);

		$this->actingAs($this->clientUser, 'api')
			 ->delete('/api/v1/client/my-fitters/' . $fitter_related->id)
			 ->assertStatus(200)
			 ->assertJson([
				 'success' => true,
			 ]);

		$this->assertDatabaseMissing('client_fitter', [
			'fitter_id' => $fitter_related->id,
			'client_id' => $this->client->id,
		]);
	}

}
