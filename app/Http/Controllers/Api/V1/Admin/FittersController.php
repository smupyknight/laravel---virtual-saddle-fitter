<?php

namespace App\Http\Controllers\Api\V1\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Fitter;

class FittersController extends Controller
{

	/**
	 * Returns only fitter-user of logged in fitter
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function getMyUsers()
	{
		$users = Auth::user()->fitter->users()->where('type', 'fitter-user')->get();

		return response()
			->json(['data' => $users]);
	}

	/**
	 * Returns all fitter-user and fitter-admin of logged in fitter
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function getMyUsersAll()
	{
		$users = Auth::user()->fitter->users;

		return response()
			->json(['data' => $users]);
	}

}