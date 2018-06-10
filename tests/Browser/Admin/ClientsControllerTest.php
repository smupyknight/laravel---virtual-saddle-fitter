<?php

namespace Tests\Browser\Admin;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ClientsControllerTest extends DuskTestCase
{

//	use DatabaseMigrations;
//
//	/**
//	 * Test clients create
//	 *
//	 * @return void
//	 */
//	public function testClientsCreate()
//	{
//		$fitter = factory(\App\Fitter::class)->create();
//
//		$user = factory(\App\User::class)->create([
//			'fitter_id' => $fitter->id,
//			'type'      => 'fitter-admin',
//		]);
//
//		$this->browse(function ($browser) use ($user) {
//			$browser->loginAs($user);
//			$browser->visit('/admin/clients/create')
//					->assertSee('Create Client')
//					->type('name', 'ABC Client')
//					->type('address', '123 Fake Street')
//					->type('suburb', 'Fakeville')
//					->type('postcode', '4000')
//					->select('state', 'QLD')
//					->press('Create Client')
//					->assertPathIs('/admin/clients');
//		});
//
//		$this->assertDatabaseHas('clients', [
//			'name'     => 'ABC Client',
//			'address'  => '123 Fake Street',
//			'suburb'   => 'Fakeville',
//			'postcode' => '4000',
//			'state'    => 'QLD',
//		]);
//	}

}