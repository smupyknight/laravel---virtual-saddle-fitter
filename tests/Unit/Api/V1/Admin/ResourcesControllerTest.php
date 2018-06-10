<?php

namespace Tests\Unit\Api\V1\Admin;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ResourcesControllerTest extends TestCase
{

	// FitterAdmin User
	private $admin;
	private $styles;
	private $colours;
	private $breeds;
	private $disciplines;

	// Prepare Tests
	public function setUp()
	{
		parent::setUp();

		$fitter = factory(\App\Fitter::class)->create();
		$this->admin = factory(\App\User::class)->create([
			'fitter_id' => $fitter->id,
			'type'      => 'fitter-admin',
		]);

		// Create test styles
		$this->styles = factory(\App\Style::class, 5)->create();

		// Test Breeds
		$this->breeds = factory(\App\Breed::class, 5)->create();

		$this->colours = \App\Horse::COLOURS;

		$this->disciplines = \App\Discipline::ALL;
	}

	// FitterAdmin should be able to get styles, colours, breeds, disciplines
	public function testGetIndex()
	{
		foreach ($this->styles as $style) {
			$_styles[] = [
				'id'         => $style->id,
				'name'       => $style->name,
				'brand_id'   => $style->brand->id,
				'brand_name' => $style->brand->name,
				'type_id'    => $style->type->id,
				'type_name'  => $style->type->name,
			];
		}

		foreach ($this->colours as $colour) {
			$_colours[] = $colour;
		}

		foreach ($this->breeds as $breed) {
			$_breeds[] = [
				'id'   => $breed->id,
				'name' => $breed->name,
			];
		}

		$_disciplines = $this->disciplines;

		$data = [
			'styles'      => $_styles,
			'colours'     => $_colours,
			'breeds'      => $_breeds,
			'disciplines' => $_disciplines,
		];

		$this->actingAs($this->admin, 'api')
			 ->get('/api/v1/admin/resources')
			 ->assertStatus(200)
			 ->assertJson($data);
	}

	// FitterAdmin should be able to get fitter options
	public function testGetFitCheckOptions()
	{
		$this->actingAs($this->admin, 'api')
			 ->get('/api/v1/admin/resources/fitcheck-options')
			 ->assertStatus(200)
			 ->assertJson(['fitcheck-options' =>  \App\FitCheck::OPTIONS]);
	}

}
