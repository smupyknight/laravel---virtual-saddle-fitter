<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\ClientFitter;
use App\Jobs\SendNewClientEmail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Auth;
use App\User;
use App\Client;
use App\Invitation;

class ClientsController extends Controller
{

	public function index(Request $request)
	{
		$query = Auth::user()->fitter->clients();

		if ($request->search) {
			$query->where(function ($query) use ($request) {
				$query->orWhere('name', 'like', '%' . $request->search . '%');
				$query->orWhere('email', 'like', '%' . $request->search . '%');
			});
		}

		$clients = $query->orderBy('id', 'asc')->paginate($request->get('per_page', 25));

		$data = [];

		foreach ($clients as $client) {
			$data[] = [
				'id'       => $client->id,
				'name'     => $client->name,
				'email'    => $client->email,
				'address'  => $client->address,
				'suburb'   => $client->suburb,
				'postcode' => $client->postcode,
				'state'    => $client->state,
			];
		}

		$result = [
			'total'         => $clients->total(),
			'per_page'      => $clients->perPage(),
			'current_page'  => $clients->currentPage(),
			'last_page'     => $clients->lastPage(),
			'next_page_url' => $clients->nextPageUrl(),
			'prev_page_url' => $clients->previousPageUrl(),
			'from'          => $clients->firstItem(),
			'to'            => $clients->lastItem(),
			'data'          => $data,
		];

		return response()->json($result);
	}

	public function post(Request $request)
	{
		$this->validate($request, [
			'name'     => 'required',
			'email'    => 'required|unique:users,email',
			'address'  => 'required',
			'suburb'   => 'required',
			'postcode' => 'required|digits:4',
			'state'    => 'required|in:ACT,QLD,NSW,NT,SA,WA,TAS,VIC',
		]);

		$client = new Client;

		$client->name = $request->name;
		$client->email = $request->email;
		$client->address = $request->address;
		$client->suburb = $request->suburb;
		$client->postcode = $request->postcode;
		$client->state = $request->state;
		$client->save();

		Auth::user()->fitter->clients()->attach($client->id);

		// Prepare a new user for the client as the default login account
		$user = new User;
		$user->createUserFromModel($client, User::$TYPE_USER);

		// Set an email to the new client to complete the user account
		$this->dispatch(new SendNewClientEmail($user));

		return response()
			->json([
				'success' => true,
				'id'      => $client->id,
			], 200);
	}

	public function get($id)
	{
		$client = Auth::user()->fitter->clients()->findOrFail($id);

		$horses = [];
		$riders = [];
		$saddles = [];
		$users = [];

		foreach ($client->horses as $horse) {
			$horses[] = [
				'id'              => $horse->id,
				'stable_name'     => $horse->stable_name,
				'breeding_name'   => $horse->breeding_name,
				'paddock_address' => $horse->paddock_address,
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

		foreach ($client->riders as $rider) {
			$riders[] = [
				'id'                        => $rider->id,
				'first_name'                => $rider->first_name,
				'last_name'                 => $rider->last_name,
				'address'                   => $rider->address,
				'mobile'                    => $rider->mobile,
				'email'                     => $rider->email,
				'discipline'                => $rider->discipline,
				'stirrup_size'              => $rider->stirrup_size,
				'stirrup_leahter'           => $rider->stirrup_leahter,
				'height'                    => $rider->height,
				'jodphur_size'              => $rider->jodphur_size,
				'is_vip_member'             => $rider->is_vip_member,
				'award_points'              => $rider->award_points,
				'has_registered_on_website' => $rider->has_registered_on_website,
				'created_at'                => $rider->created_at->format('d/m/Y'),
				'updated_at'                => $rider->updated_at->format('d/m/Y'),
			];
		}

		foreach ($client->saddles as $saddle) {
			$saddles[] = [
				'id'            => $saddle->id,
				'brand_name'    => $saddle->brand->name,
				'model'         => $saddle->model,
				'serial_number' => $saddle->serial_number,
				'rider'         => $saddle->rider->getFullName(),
				'horse_name'    => $saddle->horse->stable_name,
				'created_at'    => $saddle->created_at->format('d/m/Y'),
				'updated_at'    => $saddle->updated_at->format('d/m/Y'),
			];
		}

		foreach ($client->users as $user) {
			$users[] = [
				'id'         => $user->id,
				'first_name' => $user->first_name,
				'last_name'  => $user->last_name,
				'status'     => $user->invitation ? 'Invited' : 'Active',
				'email'      => $user->email,
			];
		}

		$data = [
			'client'  => [
				'id'       => $client->id,
				'name'     => $client->name,
				'email'    => $client->email,
				'address'  => $client->address,
				'suburb'   => $client->suburb,
				'postcode' => $client->postcode,
				'state'    => $client->state,
			],
			'horses'  => $horses,
			'riders'  => $riders,
			'saddles' => $saddles,
			'users'   => $users,
		];

		return response()->json($data);
	}

	public function put(Request $request, $id)
	{
		$this->validate($request, [
			'name'     => 'required',
			'email'    => 'required',
			'address'  => 'required',
			'suburb'   => 'required',
			'postcode' => 'required|digits_between:3,4',
			'state'    => 'required|in:ACT,QLD,NSW,NT,SA,WA,TAS,VIC',
		]);

		$client = Client::findOrFail($id);

		$client->name = $request->name;
		$client->email = $request->email;
		$client->address = $request->address;
		$client->suburb = $request->suburb;
		$client->postcode = $request->postcode;
		$client->state = $request->state;

		$client->save();

		return response()
			->json([
				'success' => true,
				'id'      => $client->id,
			], 200);
	}

	public function delete(Request $request, $id)
	{
		$client = Client::findOrFail($id);

		// Check safety
		$errors = [];

		// Check if related to any horses.
		$horses = [];
		foreach ($client->horses as $horse) {
			$horses[] = $horse->id;
		}

		if (count($horses)) {
			$errors['horses'] = 'Related horse ids: ' . implode(',', $horses);
		}

		// Check if related to any riders.
		$riders = [];
		foreach ($client->riders as $rider) {
			$riders[] = $rider->id;
		}

		if (count($riders)) {
			$errors['riders'] = 'Related rider ids: ' . implode(',', $riders);
		}

		// Check if related to any bookings.
		$bookings = [];
		foreach ($client->bookings as $booking) {
			$bookings[] = $booking->id;
		}

		if (count($bookings)) {
			$errors['bookings'] = 'Related booking ids: ' . implode(',', $bookings);
		}

		// Return error
		if (count($errors)) {
			return response()
				->json(array_merge([
					'error' => 'This Client is related with other entities!',
				], $errors), 422);
		}

		Auth::user()->fitter->clients()->detach($client->id);

		$client->delete();

		return response()
			->json(['success' => true], 200);
	}

	public function postInviteUser(Request $request, $id)
	{
		$this->validate($request, [
			'first_name' => 'required|string|max:255',
			'last_name'  => 'required|string|max:255',
			'email'      => 'required|email|max:255|unique:users',
		]);

		// Create a client user, related invitation object, send invitation email.
		$client = Client::findOrFail($id);

		$user = User::create([
			'client_id'  => $client->id,
			'first_name' => $request->first_name,
			'last_name'  => $request->last_name,
			'type'       => 'user',
			'email'      => $request->email,
		]);

		$invitation = Invitation::create([
			'user_id' => $user->id,
			'token'   => substr(md5(microtime()), 0, 10),
		]);

		$invitation->send();

		return response()
			->json([
				'success' => true,
				'id'      => $user->id,
				'email'   => $user->email,
			]);
	}

	public function postCreateUser(Request $request, $id)
	{
		$this->validate($request, [
			'first_name' => 'required|string|max:255',
			'last_name'  => 'required|string|max:255',
			'email'      => 'required|email|max:255|unique:users',
			'password'   => 'required|confirmed|min:6|max:255',
		]);

		// Create a client user.
		$client = Client::findOrFail($id);

		$user = User::create([
			'client_id'  => $client->id,
			'first_name' => $request->first_name,
			'last_name'  => $request->last_name,
			'type'       => 'user',
			'email'      => $request->email,
			'password'   => bcrypt($request->password),
		]);

		return response()
			->json([
				'success' => true,
				'id'      => $user->id,
			]);
	}

	public function putUpdateUser(Request $request, $id, $userId)
	{
		$user = Client::findOrFail($id)->users()->findOrFail($userId);

		$this->validate($request, [
			'first_name' => 'required|string|max:255',
			'last_name'  => 'required|string|max:255',
			'email'      => 'required|email|max:255|unique:users,email,' . $user->id,
			'password'   => 'confirmed|min:6|max:255',
		]);

		$user->first_name = $request->first_name;
		$user->last_name = $request->last_name;
		$user->email = $request->email;

		if (!empty($request->password)) {
			$user->password = bcrypt($request->password);
		}

		$user->save();

		return response()
			->json([
				'success' => true,
				'id'      => $user->id,
			]);
	}

	public function deleteUser(Request $request, $id, $userId)
	{
		Client::findOrFail($id)->users()->findOrFail($userId)->delete();

		return response()
			->json([
				'success' => true,
			]);
	}

	public function getUser(Request $request, $id, $userId)
	{
		$user = Client::findOrFail($id)->users()->findOrFail($userId);

		return response()
			->json($user);
	}

}