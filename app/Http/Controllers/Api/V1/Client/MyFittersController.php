<?php

namespace App\Http\Controllers\Api\V1\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Fitter;
use App\Client;
use App\ClientFitter;
use Auth;
use App\User;

class MyFittersController extends Controller
{

	/**
	 * @param Request $request {related: boolean} search related / non related fitters
	 * @return \Illuminate\Http\JsonResponse {data:[{'related':boolean}]}
	 */
	public function index(Request $request)
	{
		$client = Auth::user()->client;

		if ($request->get('related', 'false') == 'true') {
			// Returns only related fitters
			$query = $client->fitters();
		} else {
			// Returns all fitters
			$query = Fitter::query();
		}

		$query->where(function ($query) use ($request) {
			$query->orWhere('name', 'like', '%' . $request->search . '%');
			$query->orWhere('email', 'like', '%' . $request->search . '%');
		});

		$result_array = $query->paginate($request->get('per_page', 25))->toArray();

		if ($request->get('related', 'false') == 'true') {
			// My related fitters
			foreach ($result_array['data'] as $key => $value) {
				$result_array['data'][$key]['related'] = true;
			}
		} else {
			// All fitters, check if related
			foreach ($result_array['data'] as $key => $value) {
				$result_array['data'][$key]['related'] = (ClientFitter::where('client_id', $client->id)
																	  ->where('fitter_id', $value['id'])
																	  ->first()) ? true : false;
			}
		}

		return response()
			->json($result_array);
	}

	public function postAdd(Request $request, $id)
	{
		$fitter = Fitter::findOrFail($id);
		Auth::user()->client->fitters()->attach($fitter->id);

		return response()
			->json([
				'success' => true,
			]);
	}

	public function delete(Request $request, $id)
	{
		$fitter = Fitter::findOrFail($id);
		Auth::user()->client->fitters()->detach($fitter->id);

		return response()
			->json([
				'success' => true,
			]);
	}

}
