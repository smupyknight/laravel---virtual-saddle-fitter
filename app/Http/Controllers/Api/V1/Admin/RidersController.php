<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Discipline;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Rider;
use App\Client;
use Illuminate\Validation\Rule;

class RidersController extends Controller
{

	public function index(Request $request)
	{
		// Get list of riders
		$query = Auth::user()->fitter->riders();

		if ($request->search) {
			$query->where(function ($query) use ($request) {
				$query->orWhereRaw("CONCAT(riders.first_name, ' ', riders.last_name) LIKE ?", ['%' . $request->search . '%']);
				$query->orWhere('riders.email', 'LIKE', '%' . $request->search . '%');
			});
		}

		$riders = $query->orderBy('id', 'asc')->paginate($request->get('per_page', 25));

		return response()
			->json($riders);
	}

	public function post(Request $request)
	{
		$this->validate($request, [
			'client_id'                 => 'required',
			'first_name'                => 'required|string',
			'last_name'                 => 'required|string',
			'address'                   => 'required',
			'postcode'                  => 'required|digits:4',
			'suburb'                    => 'required',
			'state'                     => 'required',
			'mobile'                    => 'required|numeric|mobile',
			'email'                     => 'required|email|unique:riders,email',
			'discipline'                => 'required|' . Rule::in(Discipline::ALL),
			'stirrup_size'              => 'required',
			'stirrup_leather'           => 'required',
			'height'                    => 'required',
			'jodphur_size'              => 'string',
			'is_vip_member'             => 'boolean',
			'award_points'              => 'required|min:0',
			'has_registered_on_website' => 'boolean',
		]);

		$rider = new Rider;

		$rider->client_id = $request->client_id;
		$rider->first_name = $request->first_name;
		$rider->last_name = $request->last_name;
		$rider->address = $request->address;
		$rider->postcode = $request->postcode;
		$rider->suburb = $request->suburb;
		$rider->state = $request->state;
		$rider->mobile = $request->mobile;
		$rider->email = $request->email;
		$rider->discipline = $request->discipline;
		$rider->stirrup_size = $request->stirrup_size;
		$rider->stirrup_leather = $request->stirrup_leather;
		$rider->height = $request->height;
		$rider->jodphur_size = $request->jodphur_size;
		$rider->is_vip_member = $request->is_vip_member;
		$rider->award_points = $request->award_points;
		$rider->has_registered_on_website = $request->has_registered_on_website;

		$rider->save();

		return response()
			->json([
				'success' => true,
				'id'      => $rider->id,
			], 200);
	}

	public function get($id)
	{
		$rider = Rider::findOrfail($id);
		$client = Client::findOrFail($rider->client_id);

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

		return response()->json($data);
	}

	public function put(Request $request, $id)
	{
		$this->validate($request, [
			'client_id'                 => 'required',
			'first_name'                => 'required|string',
			'last_name'                 => 'required|string',
			'address'                   => 'required',
			'postcode'                  => 'required|digits:4',
			'state'                     => 'required',
			'suburb'                    => 'required',
			'mobile'                    => 'required|numeric|mobile',
			'email'                     => 'required|email|unique:riders,email,' . $id,
			'discipline'                => 'required|' . Rule::in(Discipline::ALL),
			'stirrup_size'              => 'required',
			'stirrup_leather'           => 'required',
			'height'                    => 'required',
			'jodphur_size'              => 'required',
			'is_vip_member'             => 'boolean',
			'award_points'              => 'required|min:0',
			'has_registered_on_website' => 'boolean',
		]);

		$rider = Rider::findOrFail($id);

		$rider->client_id = $request->client_id;
		$rider->first_name = $request->first_name;
		$rider->last_name = $request->last_name;
		$rider->address = $request->address;
		$rider->postcode = $request->postcode;
		$rider->suburb = $request->suburb;
		$rider->state = $request->state;
		$rider->mobile = $request->mobile;
		$rider->email = $request->email;
		$rider->discipline = $request->discipline;
		$rider->stirrup_size = $request->stirrup_size;
		$rider->stirrup_leather = $request->stirrup_leather;
		$rider->height = $request->height;
		$rider->jodphur_size = $request->jodphur_size;
		$rider->is_vip_member = $request->is_vip_member;
		$rider->award_points = $request->award_points;
		$rider->has_registered_on_website = $request->has_registered_on_website;

		$rider->save();

		return response()
			->json([
				'success' => true,
				'id'      => $rider->id,
			], 200);
	}

	public function delete($id)
	{
		$rider = Rider::findOrFail($id);

		// Check safety
		$errors = [];

		// Check if related to any saddles.
		$saddles = [];
		foreach ($rider->saddles as $saddle) {
			$saddles[] = $saddle->id;
		}

		if (count($saddles)) {
			$errors['saddles'] = 'Related saddles ids: ' . implode(',', $saddles);
		}

		// Check if related to any bookings.
		$bookings = [];
		foreach ($rider->bookings as $booking) {
			$bookings[] = $booking->id;
		}

		if (count($bookings)) {
			$errors['bookings'] = 'Related bookings ids: ' . implode(',', $bookings);
		}

		// Check if related to any fitchecks.
		$fitchecks = [];
		foreach ($rider->fitchecks as $fitcheck) {
			$fitchecks[] = $fitcheck->id;
		}

		if (count($fitchecks)) {
			$errors['fitchecks'] = 'Related fitchecks ids: ' . implode(',', $fitchecks);
		}

		// Return error
		if (count($errors)) {
			return response()
				->json(array_merge([
					'error' => 'This Rider is related with other entities!',
				], $errors), 422);
		}

		// No related models? delete
		$rider->delete();

		return response()
			->json(['success' => true], 200);
	}

}
