<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Discipline;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

use App\Horse;
use Auth;
use Carbon\Carbon;

class HorsesController extends Controller
{

	/**
	 * Get all horses under a fitter
	 * @param Request $request
	 * @return json
	 */
	public function getIndex(Request $request)
	{
		$query = Auth::user()->fitter->horses();

		if ($request->search) {
			$query->where(function ($query) use ($request) {
				$query->orWhere('stable_name', 'like', '%' . $request->search . '%');
				$query->orWhere('breeding_name', 'like', '%' . $request->search . '%');
			});
		}

		$horses = $query->orderBy('id', 'asc')->paginate($request->get('per_page', 25));

		$data = [];

		foreach ($horses as $item) {
			$horse = Horse::find($item->id);
			$data[] = [
				'id'            => $horse->id,
				'client_name'   => $horse->client->name,
				'stable_name'   => $horse->stable_name,
				'breeding_name' => $horse->breeding_name,
				'breed'         => $horse->breed,
				'colour'        => $horse->colour,
				'discipline'    => $horse->discipline,
				'age'           => $horse->age,
				'sex'           => $horse->sex,
			];
		}

		$result = [
			'total'         => $horses->total(),
			'per_page'      => $horses->perPage(),
			'current_page'  => $horses->currentPage(),
			'last_page'     => $horses->lastPage(),
			'next_page_url' => $horses->nextPageUrl(),
			'prev_page_url' => $horses->previousPageUrl(),
			'from'          => $horses->firstItem(),
			'to'            => $horses->lastItem(),
			'data'          => $data,
		];

		return response()->json($result);
	}

	/**
	 * Get a horse by id
	 * @param  int $horse_id
	 * @return json
	 */
	public function getView($horse_id)
	{
		$horse = Horse::findOrFail($horse_id);

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
			'client'           => $horse->client,
			'client_id'        => $horse->client->id,
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

		return response()->json($data);
	}

	public function postCreate(Request $request)
	{
		$this->validate($request, [
			'client_id'        => 'required',
			'stable_name'      => 'required',
			'breeding_name'    => '',
			'paddock_address'  => 'required',
			'postcode'         => 'required|digits:4',
			'state'            => 'required',
			'suburb'           => 'required',
			'breed'            => 'required|exists:horse_breeds,name',
			'height'           => 'required|numeric|min:1|max:1000',
			'weight'           => 'required|numeric|min:1|max:1000',
			'girth'            => 'required|numeric|min:1|max:1000',
			'colour'           => 'required|in:' . implode(',', Horse::COLOURS),
			'age'              => 'required|numeric|min:1|max:100',
			'dob'              => 'required|date_Format:d/m/Y|before:today',
			'discipline'       => 'required|' . Rule::in(Discipline::ALL),
			'sex'              => 'required|in:Stallion,Mare,Gelding',
			'photo'            => '',
			'microchip_number' => '',
		]);

		$horse = new Horse;

		$horse->client_id = $request->client_id;
		$horse->stable_name = $request->stable_name;
		$horse->breeding_name = $request->get('breeding_name', '');
		$horse->paddock_address = $request->paddock_address;
		$horse->postcode = $request->postcode;
		$horse->suburb = $request->suburb;
		$horse->state = $request->state;
		$horse->breed = $request->breed;
		$horse->colour = $request->colour;
		$horse->height = $request->height;
		$horse->weight = $request->weight;
		$horse->girth = $request->girth;
		$horse->age = $request->age;
		$horse->dob = $request->dob ? Carbon::createFromFormat('d/m/Y', $request->dob) : '';
		$horse->discipline = $request->discipline;
		$horse->sex = $request->sex;
		$horse->photo = 'default.jpg';
		$horse->microchip_number = $request->get('microchip_number', '');

		$horse->save();

		return response()->json([
			'success' => true,
			'id'      => $horse->id,
		]);
	}

	public function put(Request $request, $id)
	{
		$this->validate($request, [
			'client_id'        => 'required',
			'stable_name'      => 'required',
			'breeding_name'    => '',
			'paddock_address'  => 'required',
			'postcode'         => 'required|digits:4',
			'state'            => 'required',
			'breed'            => 'required|exists:horse_breeds,name',
			'suburb'           => 'required',
			'height'           => 'required|numeric|min:1|max:1000',
			'weight'           => 'required|numeric|min:1|max:1000',
			'girth'            => 'required|numeric|min:1|max:1000',
			'colour'           => 'required|in:' . implode(',', Horse::COLOURS),
			'age'              => 'required|numeric|min:1|max:100',
			'dob'              => 'required|date_Format:d/m/Y|before:today',
			'discipline'       => 'required|' . Rule::in(Discipline::ALL),
			'sex'              => 'required|in:Stallion,Mare,Gelding',
			'microchip_number' => '',
		]);

		$horse = Horse::findOrFail($id);

		$horse->client_id = $request->client_id;
		$horse->stable_name = $request->stable_name;
		$horse->breeding_name = $request->get('breeding_name', '');
		$horse->paddock_address = $request->paddock_address;
		$horse->postcode = $request->postcode;
		$horse->state = $request->state;
		$horse->breed = $request->breed;
		$horse->suburb = $request->suburb;
		$horse->colour = $request->colour;
		$horse->height = $request->height;
		$horse->weight = $request->weight;
		$horse->girth = $request->girth;
		$horse->age = $request->age;
		$horse->dob = $request->dob ? Carbon::createFromFormat('d/m/Y', $request->dob) : '';
		$horse->discipline = $request->discipline;
		$horse->sex = $request->sex;
		$horse->microchip_number = $request->get('microchip_number', '');

		$horse->save();

		return response()->json([
			'success' => true,
			'id'      => $horse->id,
		]);
	}

	public function delete(Request $request, $id)
	{
		$horse = Horse::findOrFail($id);

		// Check safety
		$errors = [];

		// Check if related to any saddles.
		$saddles = [];
		foreach ($horse->saddles as $saddle) {
			$saddles[] = $saddle->id;
		}

		if (count($saddles)) {
			$errors['saddles'] = 'Related saddles ids: ' . implode(',', $saddles);
		}

		// Check if related to any bookings.
		$bookings = [];
		foreach ($horse->bookings as $booking) {
			$bookings[] = $booking->id;
		}

		if (count($bookings)) {
			$errors['bookings'] = 'Related bookings ids: ' . implode(',', $bookings);
		}

		// Check if related to any fitchecks.
		$fitchecks = [];
		foreach ($horse->fitchecks as $fitcheck) {
			$fitchecks[] = $fitcheck->id;
		}

		if (count($fitchecks)) {
			$errors['fitchecks'] = 'Related fitchecks ids: ' . implode(',', $fitchecks);
		}

		// Return error
		if (count($errors)) {
			return response()
				->json(array_merge([
					'error' => 'This Horse is related with other entities!',
				], $errors), 422);
		}

		$horse->delete();

		return response()
			->json(['success' => true]);
	}

}
