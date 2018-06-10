<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Invitation;
use App\User;
use Auth;

class InvitationsController extends Controller
{

	public function getAccept($token)
	{
		try {
			$invitation = Invitation::whereToken($token)->firstOrFail();
		} catch (ModelNotFoundException $e) {
			return view('auth.invitations-fail');
		}

		return view('auth.invitations-accept')
			->with('invitation', $invitation)
			->with('user', $invitation->user);
	}

	public function postAccept(Request $request, $token)
	{
		$invitation = Invitation::whereToken($token)->firstOrFail();

		$user = $invitation->user;

		$this->validate($request, [
			'first_name' => 'required',
			'last_name'  => 'required',
			'email'      => 'required|unique:users,email,'.$user->id,
			'password'   => 'required|confirmed',
		]);

		$user->first_name = $request->first_name;
		$user->last_name = $request->last_name;
		$user->email = $request->email;
		$user->password = bcrypt($request->password);

		$user->save();

		$invitation->delete();

		Auth::login($user);

		return redirect('/');
	}

}
