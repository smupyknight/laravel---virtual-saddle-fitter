<?php

namespace Tests\Browser\Admin;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

use App\ClientFitter;

class HorsesControllerTest extends DuskTestCase
{

//	use DatabaseMigrations;
//
//	/**
//	 * Test horses create
//	 *
//	 * @return void
//	 */
//	public function testHorsesCreate()
//	{
//		$fitter = factory(\App\Fitter::class)->create();
//
//		$user = factory(\App\User::class)->create([
//			'fitter_id' => $fitter->id,
//			'type'      => 'fitter-admin',
//		]);
//
//		$client = factory(\App\Client::class)->create();
//		$breed = factory(\App\Breed::class)->create();
//
//		$client_fitter = new ClientFitter;
//
//		$client_fitter->client_id = $client->id;
//		$client_fitter->fitter_id = $fitter->id;
//
//		$client_fitter->save();
//
//		$this->browse(function ($browser) use ($user, $client) {
//			$browser->loginAs($user);
//			$browser->visit('/admin/horses/create')
//					->assertSee('Create Horse')
//					->select('client', $client->id)
//					->type('stable_name', 'Horsey')
//					->select('breed')
//					->select('colour')
//					->type('height', '1.0')
//					->type('weight', '173')
//					->type('girth', '5.44')
//					->type('age', '17')
//					->type('discipline', 'Dressage')
//					->radio('sex', 'Stallion')
//					->press('Create Horse')
//					->assertPathIs('/admin/horses')
//					->visit('/dashboard');
//		});
//
//		$this->assertDatabaseHas('horses', [
//			'stable_name'     => 'Horsey',
//			'breeding_name'   => 'Horsay',
//			'paddock_address' => '123 Fake Street',
//			'breed'           => 'Mustang',
//			'colour'          => 'Black',
//			'height'          => '1.0',
//			'weight'          => '173',
//			'girth'           => '5.44',
//			'age'             => '17',
//			'discipline'      => 'Dressage',
//			'sex'             => 'Stallion',
//		]);
//	}
//
//	/**
//	 * Test horses create
//	 *
//	 * @return void
//	 */
//	public function testHorsesEdit()
//	{
//		$fitter = factory(\App\Fitter::class)->create();
//
//		$user = factory(\App\User::class)->create([
//			'fitter_id' => $fitter->id,
//			'type'      => 'fitter-admin',
//		]);
//
//		$client = factory(\App\Client::class)->create();
//
//		$client_fitter = new ClientFitter;
//
//		$client_fitter->client_id = $client->id;
//		$client_fitter->fitter_id = $fitter->id;
//
//		$client_fitter->save();
//
//		$horse = factory(\App\Horse::class)->create([
//			'client_id' => $client->id,
//		]);
//
//		$this->assertDatabaseHas('horses', [
//			'id'              => $horse->id,
//			'stable_name'     => $horse->stable_name,
//			'breeding_name'   => $horse->breeding_name,
//			'paddock_address' => $horse->paddock_address,
//			'breed'           => $horse->breed,
//			'colour'          => $horse->colour,
//			'height'          => $horse->height,
//			'weight'          => $horse->weight,
//			'girth'           => $horse->girth,
//			'age'             => $horse->age,
//			'discipline'      => $horse->discipline,
//			'sex'             => $horse->sex,
//		]);
//
//		$this->browse(function ($browser) use ($user, $client, $horse) {
//			$browser->loginAs($user);
//			$browser->visit('/admin/horses/edit/'.$horse->id)
//					->assertSee('Edit Horse')
//					->type('stable_name', 'Horse')
//					->type('breeding_name', 'Cool Horse')
//					->type('paddock_address', '321 Fake Street')
//					->type('breed', 'test')
//					->type('colour', 'green')
//					->type('height', '12.0')
//					->type('weight', '273')
//					->type('girth', '6.44')
//					->type('age', '19')
//					->type('discipline', 'Dressage')
//					->radio('sex', 'Mare')
//					->press('Edit Horse')
//					->assertPathIs('/admin/horses')
//					->visit('/dashboard');
//		});
//
//		$this->assertDatabaseHas('horses', [
//			'id'              => $horse->id,
//			'stable_name'     => 'Horse',
//			'breeding_name'   => 'Cool Horse',
//			'paddock_address' => '321 Fake Street',
//			'breed'           => 'Thoroughbred',
//			'colour'          => 'Green',
//			'height'          => '12.0',
//			'weight'          => '273',
//			'girth'           => '6.44',
//			'age'             => '19',
//			'discipline'      => 'Dressage',
//			'sex'             => 'Mare',
//		]);
//	}

}