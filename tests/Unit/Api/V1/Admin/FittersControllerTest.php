<?php

namespace Tests\Unit\Api\V1\Admin;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class FittersControllerTest extends TestCase
{

	// FitterAdmin User
	private $admin;
	private $admins;
	private $users;

	// Prepare Tests
	public function setUp()
	{
		parent::setUp();

		$fitter = factory(\App\Fitter::class)->create();

		$this->admins = factory(\App\User::class, 5)->create([
			'fitter_id' => $fitter->id,
			'type'      => 'fitter-admin',
		]);

		$this->admin = $this->admins[0];

		$this->users = factory(\App\User::class, 5)->create([
			'fitter_id' => $fitter->id,
			'type'      => 'fitter-user',
		]);
	}

	// FitterAdmin should be able get fitter-admin, fitter-users users of his fitter
	public function testGetMyUsersAll()
	{
		$data = [];

		foreach ($this->admins as $user) {
			$data[] = $user->toArray();
		}

		foreach ($this->users as $user) {
			$data[] = $user->toArray();
		}

		$this->actingAs($this->admin, 'api')
			 ->get('/api/v1/admin/fitters/my-users-all')
			 ->assertStatus(200)
			 ->assertJson(['data' => $data]);
	}

	// FitterAdmin should be able get only fitter-users of his fitter
	public function testGetMyUsers()
	{
		$data = [];

		foreach ($this->users as $user) {
			$data[] = $user->toArray();
		}

		$this->actingAs($this->admin, 'api')
			 ->get('/api/v1/admin/fitters/my-users')
			 ->assertStatus(200)
			 ->assertJson(['data' => $data]);
	}

}
