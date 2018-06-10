<?php

namespace App\Http\Controllers\Api\V1\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Booking;
use Carbon\Carbon;
use Auth;
use App\User;
use App\Horse;
use App\Rider;

class BookingsController extends Controller
{

	public function index(Request $request)
	{
		$query = Auth::user()->fitter->bookings();

		switch ($request->booking_status) {
			case 'upcoming':
				$query = $query->where('date', '>', Carbon::now());
				break;
			case 'completed':
				$query = $query->where('date', '<', Carbon::now());
				break;
			default:
				break;
		}

		$bookings = $query->orderBy('date', 'desc')->paginate($request->get('per_page', 25));

		$data = [];

		foreach ($bookings as $item) {
			$booking = Booking::find($item->id);
			$data[] = [
				'id'         => $booking->id,
				'client'     => [
					'id'   => $booking->client->id,
					'name' => $booking->client->name,
				],
				'horse'      => [
					'id'          => $booking->horse->id,
					'stable_name' => $booking->horse->stable_name,
				],
				'rider'      => [
					'id'         => $booking->rider->id,
					'first_name' => $booking->rider->first_name,
					'last_name'  => $booking->rider->last_name,
				],
				'date'       => $booking->date->format('d/m/Y'),
				'created_at' => $booking->created_at->format('d/m/Y'),
				'updated_at' => $booking->updated_at->format('d/m/Y'),
			];
		}

		$result = [
			'total'         => $bookings->total(),
			'per_page'      => $bookings->perPage(),
			'current_page'  => $bookings->currentPage(),
			'last_page'     => $bookings->lastPage(),
			'next_page_url' => $bookings->nextPageUrl(),
			'prev_page_url' => $bookings->previousPageUrl(),
			'from'          => $bookings->firstItem(),
			'to'            => $bookings->lastItem(),
			'data'          => $data,
		];

		return response()->json($result);
	}

	public function get($id)
	{
		$booking = Booking::findOrFail($id);

		$data = [
			'id'         => $booking->id,
			'client'     => [
				'id'   => $booking->client->id,
				'name' => $booking->client->name,
			],
			'horse'      => [
				'id'          => $booking->horse->id,
				'stable_name' => $booking->horse->stable_name,
			],
			'rider'      => [
				'id'         => $booking->rider->id,
				'first_name' => $booking->rider->first_name,
				'last_name'  => $booking->rider->last_name,
			],
			'user'       => [
				'id'         => $booking->user ? $booking->user->id : '',
				'first_name' => $booking->user ? $booking->user->first_name : '',
				'last_name'  => $booking->user ? $booking->user->last_name : '',
			],
			'saddle'     => [
				'id'   => $booking->saddle ? $booking->saddle->id : '',
				'name' => $booking->saddle ? $booking->saddle->name : '',
			],
			'date'       => $booking->date->format('d/m/Y'),
			'address'    => $booking->address,
			'created_at' => $booking->created_at->format('d/m/Y'),
			'updated_at' => $booking->updated_at->format('d/m/Y'),
		];

		return response()->json($data);
	}

	public function post(Request $request)
	{
		$this->validate($request, [
			'client_id' => 'required',
			'horse_id'  => 'required',
			'rider_id'  => 'required',
			'user_id'   => '',
			'saddle_id' => '',
			'date'      => 'required|date_Format:d/m/Y|after_or_equal:today',
			'address'   => 'required',
		]);

		$errors = [];

		if (Auth::user()->fitter->clients()->find($request->client_id) == null) {
			$errors[] = ['client_id' => 'The selected client is invalid'];
		}

		if (Auth::user()->fitter->clients()->find(Horse::findOrFail($request->horse_id)->client_id) == null) {
			$errors[] = ['horse_id' => 'The selected horse is invalid'];
		}

		if (Auth::user()->fitter->clients()->find(Rider::findOrFail($request->rider_id)->client_id) == null) {
			$errors[] = ['rider_id' => 'The selected rider is invalid'];
		}

		if ($request->user_id && Auth::user()->fitter->users()->find($request->user_id) == null) {
			$errors[] = ['user_id' => 'The selected fitter user is invalid'];
		}

		if (count($errors)) {
			return response()->json([$errors], 422);
		}

		$booking = Booking::create([
			'fitter_id' => Auth::user()->fitter->id,
			'client_id' => $request->client_id,
			'horse_id'  => $request->horse_id,
			'rider_id'  => $request->rider_id,
			'user_id'   => !empty($request->user_id) ? $request->user_id : null,
			'saddle_id' => $request->saddle_id,
			'date'      => !empty($request->date) ? Carbon::createFromFormat('d/m/Y', $request->date) : null,
			'address'   => $request->address,
		]);

		return response()
			->json([
				'success' => true,
				'id'      => $booking->id,
			], 200);
	}

	public function put(Request $request, $id)
	{
		$this->validate($request, [
			'client_id' => 'required',
			'horse_id'  => 'required',
			'rider_id'  => 'required',
			'user_id'   => '',
			'saddle_id' => '',
			'date'      => 'required|date_Format:d/m/Y|after_or_equal:today',
			'address'   => 'required',
		]);

		$errors = [];

		if (Auth::user()->fitter->clients()->find($request->client_id) == null) {
			$errors[] = ['client_id' => 'The selected client is invalid'];
		}

		if (Auth::user()->fitter->clients()->find(Horse::findOrFail($request->horse_id)->client_id) == null) {
			$errors[] = ['horse_id' => 'The selected horse is invalid'];
		}

		if (Auth::user()->fitter->clients()->find(Rider::findOrFail($request->rider_id)->client_id) == null) {
			$errors[] = ['rider_id' => 'The selected rider is invalid'];
		}

		if ($request->user_id && Auth::user()->fitter->users()->find($request->user_id) == null) {
			$errors[] = ['user_id' => 'The selected fitter user is invalid'];
		}

		if (count($errors)) {
			return response()->json([$errors], 422);
		}

		$booking = Booking::findOrFail($id);

		$booking->update([
			'client_id' => $request->client_id,
			'horse_id'  => $request->horse_id,
			'rider_id'  => $request->rider_id,
			'user_id'   => !empty($request->user_id) ? $request->user_id : null,
			'saddle_id' => $request->saddle_id,
			'date'      => !empty($request->date) ? Carbon::createFromFormat('d/m/Y', $request->date) : null,
			'address'   => $request->address,
		]);

		return response()
			->json([
				'success' => true,
				'id'      => $booking->id,
			], 200);
	}

	public function delete($id)
	{
		$rider = Booking::findOrFail($id);
		$rider->delete();

		return response()
			->json(['success' => true], 200);
	}

}