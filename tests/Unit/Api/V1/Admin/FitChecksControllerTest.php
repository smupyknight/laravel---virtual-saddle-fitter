<?php

namespace Tests\Unit\Api\V1\Admin;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\FitCheck;
use App\Saddle;
use App\Brand;
use App\Style;

class FitChecksControllerTest extends TestCase
{

	// FitterAdmin User
	private $admin;
	private $client;
	private $riders;
	private $horses;
	private $style;
	private $fitchecks;

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

		// Create rider, horse, style
		$this->riders = factory(\App\Rider::class, 5)->create([
			'client_id' => $this->client->id,
		]);

		$this->horses = factory(\App\Horse::class, 5)->create([
			'client_id' => $this->client->id,
		]);

		$this->style = factory(\App\Style::class)->create();

		// Create dummy fitchecks
		$horse = $this->horses[0];
		$rider = $this->riders[0];

		$this->fitchecks = factory(Fitcheck::class, 5)->create([
			'horse_id' => $horse->id,
			'rider_id' => $rider->id,
			'user_id'  => $this->admin->id,
		]);
	}

	// FitterAdmin should be able to get list of fitchecks
	public function testIndex()
	{
		$response = $this->actingAs($this->admin, 'api')
						 ->get('/api/v1/admin/fitchecks?per_page=9999')
						 ->assertStatus(200);

		$data = [];
		foreach ($this->fitchecks as $fitcheck) {
			$data[] = [
				'id'         => $fitcheck->id,
				'rider'      => [
					'id'         => $fitcheck->rider->id,
					'first_name' => $fitcheck->rider->first_name,
					'last_name'  => $fitcheck->rider->last_name,
				],
				'horse'      => [
					'id'          => $fitcheck->horse->id,
					'stable_name' => $fitcheck->horse->stable_name,
				],
				'saddle'     => [
					'id'   => $fitcheck->saddle->id,
					'name' => $fitcheck->saddle->name,
				],
				'user'       => [
					'id'         => $fitcheck->user->id,
					'first_name' => $fitcheck->user->first_name,
					'last_name'  => $fitcheck->user->last_name,
				],
				'created_at' => $fitcheck->created_at->format('d/m/Y'),
				'updated_at' => $fitcheck->updated_at->format('d/m/Y'),
			];
		}

		$response->assertJsonFragment(['data' => $data]);
	}

	// FitterAdmin should be able to get a fitcheck details
	public function testGet()
	{
		$fitcheck = $this->fitchecks[0];

		$this->actingAs($this->admin, 'api')
			 ->get('/api/v1/admin/fitchecks/' . $fitcheck->id)
			 ->assertStatus(200)
			 ->assertJsonStructure([
				 'rider',
				 'horse',
				 'saddle',
				 'field_data',
			 ]);
	}

	// FitterAdmin should be able to start fitcheck
	public function testPost()
	{
		$horse = $this->horses[0];
		$rider = $this->riders[0];

		$this->actingAs($this->admin, 'api')
			 ->post('/api/v1/admin/fitchecks', [
				 'client_id' => $this->client->id,
				 'horse_id'  => $horse->id,
				 'rider_id'  => $rider->id,
				 'user_id'   => $this->admin->id,

				 'back_length'     => '',
				 'wither_template' => '',
				 'wither_shape'    => '',
				 'back_type'       => '',
				 'shoulder'        => [],
				 'abdomen'         => 'Dropped',
				 'fat_cover'       => 3,
				 'muscling'        => 3,

				 'back_angle'               => '',
				 'point_of_hip_tuber_coxae' => '',
				 'girth_position'           => 'Forward',

				 'muscle_wastage'      => [],
				 'soreness'            => [],
				 'reduced_flexibility' => [],
				 'hair_changes'        => [],
				 'palation_findings'   => [],

				 'foot_problems'  => [],
				 'feet_length'    => '',
				 'heel_balance'   => '',
				 'foot_balance'   => '',
				 'shoeing_status' => 'All 4 feet shod',

				 'movement_when_saddled'          => [],
				 'movement_when_saddled_no_rider' => [],
				 'movement_when_ridden'           => [],

				 'saddle_balance'             => 'Horizontal seat',
				 'pommel_clearance'           => 'Mounted',
				 'saddle_length'              => 'Short',
				 'tree_match_at_wither'       => 'Parallel to wither',
				 'tree_match_at_arc_of_spine' => 'Bridging',
				 'channel_depth'              => 'Shallow',
				 'channel_width'              => 'Wide',
				 'saddle_tilt'                => false,
				 'saddle_twist'               => false,
				 'contours_of_panel'          => 'Matched to central',
				 'girth_point_angle'          => 'Straight',
				 'girth_point_position'       => 'Point strap and 1',
				 'girth_type'                 => 'Shaped',
				 'girth_size'                 => 0,

				 'drops_to'        => '',
				 'sits_off_centre' => '',
				 'sits_upright'    => false,

				 'flocking_front'         => false,
				 'flocking_middle'        => false,
				 'flocking_back'          => false,
				 'alterations'            => [],
				 'history_of_alterations' => [],
				 'recommended_products'   => [],
			 ])
			 ->assertStatus(200)
			 ->assertJsonStructure([
				 'success',
				 'id',
			 ]);
	}

	// FitterAdmin should be able to update fitcheck, doing this with steps when real
	public function testPut()
	{
		$fitcheck = $this->fitchecks[0];

		$data = [
			'back_length'                    => '',
			'wither_template'                => '',
			'wither_shape'                   => '',
			'back_type'                      => '',
			'shoulder'                       => [],
			'abdomen'                        => 'Dropped',
			'fat_cover'                      => 3,
			'muscling'                       => 3,
			'back_angle'                     => 'Uphill/High Wither',
			'point_of_hip_tuber_coxae'       => 'Lower on right',
			'girth_position'                 => 'Straight',
			'muscle_wastage'                 => ['Central right', 'Back right'],
			'soreness'                       => ['Under waist of saddle'],
			'reduced_flexibility'            => ['To left', 'Croup Tuck'],
			'hair_changes'                   => ['Curly hair', 'White hair'],
			'palation_findings'              => ['Muscle tense', 'Muscle in spasms'],
			'foot_problems'                  => ['Infections', 'Pain'],
			'feet_length'                    => 'Average',
			'heel_balance'                   => 'Low heel',
			'foot_balance'                   => 'OF',
			'shoeing_status'                 => 'Back feet shod',
			'movement_when_saddled'          => [
				'Dips back when rider mounts',
				'Turns head /bites /cow kicks when saddled',
				'Bucks/ goes down when saddled',
			],
			'movement_when_saddled_no_rider' => ['Saddle moves excessively'],
			'movement_when_ridden'           => ['Resistance', 'Bucking'],
			'saddle_balance'                 => 'Uphill',
			'pommel_clearance'               => 'Girthed',
			'saddle_length'                  => 'Adequate',
			'tree_match_at_wither'           => 'Wide',
			'tree_match_at_arc_of_spine'     => 'Adequate',
			'channel_depth'                  => 'Shallow',
			'channel_width'                  => 'Wide',
			'saddle_tilt'                    => true,
			'saddle_twist'                   => true,
			'contours_of_panel'              => 'Matched to central',
			'girth_point_angle'              => 'Forward',
			'girth_point_position'           => 'Point strap and 1',
			'girth_type'                     => 'Shaped',
			'girth_size'                     => '3',
			'drops_to'                       => '',
			'sits_off_centre'                => '',
			'sits_upright'                   => false,
			'flocking_front'                 => false,
			'flocking_middle'                => false,
			'flocking_back'                  => false,
			'alterations'                    => [],
			'history_of_alterations'         => [],
			'recommended_products'           => [],
		];

		$this->actingAs($this->admin, 'api')
			 ->put('/api/v1/admin/fitchecks/' . $fitcheck->id, array_merge($data, [
				 'rider_id'  => 1,
				 'horse_id'  => 1,
				 'saddle_id' => 2,
			 ]))
			 ->assertStatus(200)
			 ->assertJsonStructure([
				 'success',
			 ]);

		$fitcheck = $fitcheck->fresh();

		$this->assertSame(json_encode($fitcheck->field_data), json_encode($data));
	}

	// FitterAdmin should be able to delete a fitcheck.
	public function testDelete()
	{
		$fitcheck = $this->fitchecks[0];

		$this->actingAs($this->admin, 'api')
			 ->delete('/api/v1/admin/fitchecks/' . $fitcheck->id)
			 ->assertStatus(200);

		$this->assertDatabaseMissing('fitchecks', ['id' => $fitcheck->id]);
	}

}
