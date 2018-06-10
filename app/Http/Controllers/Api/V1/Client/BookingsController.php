<?php

namespace App\Http\Controllers\Api\V1\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Booking;
use Carbon\Carbon;
use Auth;
use App\User;
use App\UserHorse;

class BookingsController extends Controller
{

	public function index(Request $request)
	{
		$query = Auth::user()->client->bookings();

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

		foreach ($bookings as $booking) {
			$data[] = [
				'id'         => $booking->id,
				'fitter'     => [
					'id'   => $booking->fitter ? $booking->fitter->id : '',
					'name' => $booking->fitter ? $booking->fitter->name : '',
				],
				'user'       => [
					'id'         => $booking->user ? $booking->user->id : '',
					'first_name' => $booking->user ? $booking->user->first_name : '',
					'last_name'  => $booking->user ? $booking->user->last_name : '',
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
				'saddle'     => [
					'id'   => $booking->saddle ? $booking->saddle->id : '',
					'name' => $booking->saddle ? $booking->saddle->name : '',
				],
				'date'       => $booking->date->format('d/m/Y'),
				'address'    => $booking->address,
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

	public function post(Request $request)
	{
		$this->validate($request, [
			'fitter_id' => 'required',
			'horse_id'  => 'required',
			'rider_id'  => 'required',
			'date'      => 'required|date_Format:d/m/Y|after_or_equal:today',
			'saddle_id' => '',
			'address'   => 'required',
		]);

		$errors = [];

		if (Auth::user()->client->fitters()->find($request->fitter_id) == null) {
			$errors[] = ['fitter_id' => 'The selected fitter is invalid'];
		}

		if (Auth::user()->client->horses()->find($request->horse_id) == null) {
			$errors[] = ['horse_id' => 'The selected horse is invalid'];
		}

		if (Auth::user()->client->riders()->find($request->rider_id) == null) {
			$errors[] = ['rider_id' => 'The selected rider is invalid'];
		}

		if (count($errors)) {
			return response()->json([$errors], 422);
		}

		$booking = Booking::create([
			'client_id' => Auth::user()->client->id,
			'fitter_id' => $request->fitter_id,
			'horse_id'  => $request->horse_id,
			'rider_id'  => $request->rider_id,
			'date'      => !empty($request->date) ? Carbon::createFromFormat('d/m/Y', $request->date) : null,
			'saddle_id' => $request->saddle_id,
			'address'   => $request->address,
		]);

		return response()
			->json([
				'success' => true,
				'id'      => $booking->id,
			], 200);
	}

	public function get($id)
	{
		$booking = Auth::user()->client->bookings()->findOrFail($id);

		$data = [
			'id'         => $booking->id,
			'fitter'     => [
				'id'   => $booking->fitter ? $booking->fitter->id : '',
				'name' => $booking->fitter ? $booking->fitter->name : '',
			],
			'user'       => [
				'id'         => $booking->user ? $booking->user->id : '',
				'first_name' => $booking->user ? $booking->user->first_name : '',
				'last_name'  => $booking->user ? $booking->user->last_name : '',
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

	public function put(Request $request, $id)
	{
		$this->validate($request, [
			'fitter_id' => 'required',
			'horse_id'  => 'required',
			'rider_id'  => 'required',
			'date'      => 'required|date_Format:d/m/Y|after_or_equal:today',
			'saddle_id' => '',
			'address'   => 'required',
		]);

		$errors = [];

		if (Auth::user()->client->fitters()->find($request->fitter_id) == null) {
			$errors[] = ['fitter_id' => 'The selected fitter is invalid'];
		}

		if (Auth::user()->client->horses()->find($request->horse_id) == null) {
			$errors[] = ['horse_id' => 'The selected horse is invalid'];
		}

		if (Auth::user()->client->riders()->find($request->rider_id) == null) {
			$errors[] = ['rider_id' => 'The selected rider is invalid'];
		}

		if (count($errors)) {
			return response()->json([$errors], 422);
		}

		$booking = Auth::user()->client->bookings()->findOrFail($id);

		$booking->update([
			'fitter_id' => $request->fitter_id,
			'horse_id'  => $request->horse_id,
			'rider_id'  => $request->rider_id,
			'date'      => !empty($request->date) ? Carbon::createFromFormat('d/m/Y', $request->date) : null,
			'saddle_id' => $request->saddle_id,
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
		$rider = Auth::user()->client->bookings()->findOrFail($id);
		$rider->delete();

		return response()
			->json(['success' => true], 200);
	}

}