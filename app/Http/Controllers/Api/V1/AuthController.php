<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Hash;
use Auth;

class AuthController extends Controller
{

	public function postLogin(Request $request)
	{
		$this->validate($request, [
			'email'    => 'required|email',
			'password' => 'required',
		]);

		$user = User::whereEmail($request->email)->firstOrFail();

		if (!$user || !Hash::check($request->password, $user->password)) {
			abort(401);
		}

		$token = $user->createToken('ApiAccess')->accessToken;

//		if (!$user->isFitter()) {
//			abort(401);
//		}

		return response()->json(['api_token' => $token]);
	}

	public function postRegister(Request $request)
	{
		$this->validate($request, [
			'first_name' => 'required',
			'last_name'  => 'required',
			'email'      => 'required|email|unique:users,email',
			'password'   => 'required|confirmed',
		]);

		$user = new User;

		$user->first_name = $request->first_name;
		$user->last_name = $request->last_name;
		$user->email = $request->email;
		$user->password = Hash::make($request->password);
		$user->api_token = md5(microtime());

		$user->save();

		return response()->json(['api_token' => $user->api_token]);
	}

	public function postLogout(Request $request)
	{
	}

}