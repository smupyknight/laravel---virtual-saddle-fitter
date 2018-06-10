<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
	static $password;

	return [
		'first_name'     => $faker->name,
		'last_name'      => $faker->name,
		'type'           => 'user',
		'email'          => $faker->unique()->safeEmail,
		'password'       => bcrypt('password'),
		'api_token'      => md5(microtime()),
		'remember_token' => str_random(10),
	];
});

/**
 * Factory for Fitter
 */
$factory->define(App\Fitter::class, function (Faker\Generator $faker) {
	return [
		'name'     => $faker->name,
		'abn'      => str_random(11),
		'phone'    => $faker->phoneNumber,
		'email'    => $faker->email,
		'address'  => $faker->address,
		'suburb'   => $faker->city,
		'postcode' => rand(0, 4),
		'state'    => 'QLD',
		'logo'     => $faker->url,
	];
});

/**
 * Factory for client
 */
$factory->define(App\Client::class, function (Faker\Generator $faker) {
	return [
		'name'     => $faker->name,
		'email'    => $faker->email,
		'address'  => $faker->address,
		'suburb'   => $faker->city,
		'postcode' => rand(1000, 9999) . '',
		'state'    => 'QLD',
	];
});

/**
 * Factory for client fitter relationship
 */
$factory->define(App\ClientFitter::class, function (Faker\Generator $faker) {
	return [];
});

/**
 * Factory for breed
 */
$factory->define(App\Breed::class, function (Faker\Generator $faker) {
	return [
		'name' => $faker->word,
	];
});

/**
 * Factory for horse
 */
$factory->define(App\Horse::class, function (Faker\Generator $faker) {
	$breed = factory(\App\Breed::class)->create();

	return [
		'client_id'        => factory(\App\Client::class)->create()->id,
		'stable_name'      => $faker->name,
		'breeding_name'    => $breed->name,
		'paddock_address'  => $faker->address,
		'breed'            => $breed->name,
		'colour'           => array_random(\App\Horse::COLOURS, 1)[0],
		'height'           => rand(0, 100),
		'weight'           => rand(0, 100),
		'girth'            => rand(0, 100),
		'age'              => rand(0, 100),
		'discipline'       => array_random(\App\Discipline::ALL, 1)[0],
		'sex'              => 'Stallion',
		'dob'              => $faker->dateTime,
		'microchip_number' => str_random(10),
	];
});

/**
 * Factory for rider
 */
$factory->define(App\Rider::class, function (Faker\Generator $faker) {
	return [
		'client_id'                 => factory(App\Client::class)->create()->id,
		'first_name'                => $faker->firstName,
		'last_name'                 => $faker->lastName,
		'address'                   => $faker->address,
		'mobile'                    => $faker->phoneNumber,
		'email'                     => $faker->email,
		'postcode'                  => $faker->postcode,
		'state'                     => 'QLD',
		'suburb'                    => str_random(3),
		'discipline'                => array_random(\App\Discipline::ALL, 1)[0],
		'stirrup_size'              => rand(0, 10),
		'stirrup_leather'           => rand(0, 10),
		'height'                    => rand(0, 10),
		'jodphur_size'              => rand(0, 10),
		'is_vip_member'             => rand(0, 1),
		'award_points'              => rand(0, 100),
		'has_registered_on_website' => rand(0, 1),
	];
});

/**
 * Factory for brand
 */
$factory->define(App\Brand::class, function (Faker\Generator $faker) {
	return [
		'name' => str_random(10),
	];
});

/**
 * Factory for type
 */
$factory->define(App\Type::class, function (Faker\Generator $faker) {
	return [
		'name' => str_random(10),
	];
});

/**
 * Factory for style
 */
$factory->define(App\Style::class, function (Faker\Generator $faker) {
	return [
		'brand_id' => factory(App\Brand::class)->create()->id,
		'type_id'  => factory(App\Type::class)->create()->id,
		'name'     => str_random(10),
	];
});

/**
 * Factory for saddle
 */
$factory->define(App\Saddle::class, function (Faker\Generator $faker) {
	$brand = factory(\App\Brand::class)->create();
	$type = factory(\App\Type::class)->create();
	$style = factory(\App\Style::class)->create(['brand_id' => $brand->id, 'type_id' => $type->id]);

	return [
		'horse_id'      => factory(\App\Horse::class)->create()->id,
		'rider_id'      => factory(\App\Rider::class)->create()->id,
		'brand_id'      => $brand->id,
		'style_id'      => $style->id,
		'serial_number' => str_random(10),
		'size'          => str_random(10),
		'type'          => 'All Purpose',
		'gullet_size'   => 'n',
		'panel_type'    => 'Flock',
		'seat_style'    => 'Standard',
		'purchased_at'  => \Carbon\Carbon::now(),
	];
});

/**
 * Factory for Booking
 */
$factory->define(App\Booking::class, function (Faker\Generator $faker) {
	$client = factory(App\Client::class)->create();
	$fitter = factory(App\Fitter::class)->create();
	$client_fitter = factory(App\ClientFitter::class)->create([
		'client_id' => $client->id,
		'fitter_id' => $fitter->id,
	]);

	return [
		'fitter_id' => $fitter->id,
		'client_id' => $client->id,
		'horse_id'  => factory(App\Horse::class)->create(['client_id' => $client->id])->id,
		'rider_id'  => factory(App\Rider::class)->create(['client_id' => $client->id])->id,
		'user_id'   => factory(App\User::class)->create([
			'fitter_id' => $fitter->id,
			'type'      => 'fitter-user',
		])->id,
		'date'      => $faker->dateTimeBetween('+1 week', '+1 month'),
	];
});

/**
 * Factory for FitCheck
 */
$factory->define(App\FitCheck::class, function (Faker\Generator $faker) {
	$client = factory(App\Client::class)->create();

	$fitter = factory(App\Fitter::class)->create();
	$client_fitter = factory(App\ClientFitter::class)->create([
		'client_id' => $client->id,
		'fitter_id' => $fitter->id,
	]);

	$horse = factory(App\Horse::class)->create(['client_id' => $client->id]);
	$rider = factory(App\Rider::class)->create(['client_id' => $client->id]);
	$saddle = factory(App\Saddle::class)->create(['horse_id' => $horse->id]);

	return [
		'horse_id'   => $horse->id,
		'saddle_id'  => $saddle->id,
		'rider_id'   => $rider->id,
		'user_id'    => factory(App\User::class)->create([
			'fitter_id' => $fitter->id,
			'type'      => 'fitter-user',
		])->id,
		'field_data' => [
			'back_length'                    => 'Short',
			'wither_template'                => '',
			'wither_shape'                   => '',
			'back_type'                      => 'Sway Back',
			'shoulder'                       => [],
			'abdomen'                        => '',
			'fat_cover'                      => 1,
			'muscling'                       => 2,
			'back_angle'                     => '',
			'point_of_hip_tuber_coxae'       => '',
			'girth_position'                 => 'Forward',
			'muscle_wastage'                 => [],
			'soreness'                       => [],
			'reduced_flexibility'            => [],
			'hair_changes'                   => [],
			'palation_findings'              => [],
			'foot_problems'                  => [],
			'feet_length'                    => '',
			'heel_balance'                   => '',
			'foot_balance'                   => '',
			'shoeing_status'                 => 'Bare foot',
			'movement_when_saddled'          => [],
			'movement_when_saddled_no_rider' => [],
			'movement_when_ridden'           => [],
			'saddle_balance'                 => 'Horizontal seat',
			'pommel_clearance'               => 'Mounted',
			'saddle_length'                  => 'Short',
			'tree_match_at_wither'           => '',
			'tree_match_at_arc_of_spine'     => 'Bridging',
			'channel_depth'                  => 'Shallow',
			'channel_width'                  => 'Wide',
			'saddle_tilt'                    => false,
			'saddle_twist'                   => false,
			'contours_of_panel'              => 'Matched to central',
			'girth_point_angle'              => 'Straight',
			'girth_point_position'           => 'Point strap and 1',
			'girth_type'                     => 'Shaped',
			'girth_size'                     => 'Neigh',
			'drops_to'                       => 'Neither',
			'sits_off_centre'                => 'Neither',
			'sits_upright'                   => true,
			'flocking_front'                 => false,
			'flocking_middle'                => false,
			'flocking_back'                  => false,
			'alterations'                    => [],
			'history_of_alterations'         => [],
			'recommended_products'           => [],
		],
	];
});

