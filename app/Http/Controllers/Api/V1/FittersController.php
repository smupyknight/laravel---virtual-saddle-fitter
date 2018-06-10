<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Fitter;

class FittersController extends Controller
{

	/**
	 * Returns a list of whole fitters at system.
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse of paginated
	 */
	public function index(Request $request)
	{
		$query = Fitter::orderBy('id');

		$query->where(function ($query) use ($request) {
			$query->orWhere('name', 'like', '%' . $request->search . '%');
			$query->orWhere('email', 'like', '%' . $request->search . '%');
		});

		return response()
			->json($query->paginate($request->get('per_page', 25)));
	}

	/**
	 * Returns fitter details.
	 * @param Request $request
	 * @param         $id Fitter id
	 * @return \Illuminate\Http\JsonResponse ['fitter', 'users']
	 */
	public function get(Request $request, $id)
	{
		$fitter = Fitter::findOrFail($id);

		$users_query = $fitter->users()->orderBy('id');

		$users_query->where(function ($query) use ($request) {
			$query->orWhere('first_name', 'like', '%' . $request->search_user . '%');
			$query->orWhere('last_name', 'like', '%' . $request->search_user . '%');
			$query->orWhere('email', 'like', '%' . $request->search_user . '%');
		});

		return response()
			->json([
				'fitter' => $fitter,
				'users'  => $users_query->get(),
			]);
	}

}
