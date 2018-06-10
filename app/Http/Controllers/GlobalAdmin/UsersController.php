<?php

namespace App\Http\Controllers\GlobalAdmin;

use Illuminate\Http\Request;
use App\User;
use App\Company;
use Auth;
use Hash;

class UsersController extends \App\Http\Controllers\Controller
{

	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function getIndex(Request $request)
	{
		$users = User::where('id', '!=', Auth::user()->id);

		if ($request->phrase) {
			$users->where('first_name', 'like', '%' . $request->phrase . '%')
				->orWhere('last_name', 'like', '%'.$request->phrase.'%')
				->orWhere('email', 'like', '%'.$request->phrase.'%');
		}

		$users = $users->paginate($request->get('per_page', 25));

		return view('pages.global-admin.users-list')
			->with('title', 'Users List')
			->with('users', $users);
	}

	/**
	 * Show user
	 * @return view
	 */
	public function getView($user_id)
	{
		$user = User::findOrFail($user_id);

		return view('pages.global-admin.users-view')
			->with('user', $user)
			->with('title', 'View User');
	}

	/**
	 * Edit user
	 * @return view
	 */
	public function getEdit($user_id)
	{
		$user = User::findOrFail($user_id);
		$companies = Company::all();

		return view('pages.global-admin.users-edit')
			->with('user', $user)
			->with('companies', $companies)
			->with('title', 'Edit User');
	}

	/**
	 * Handle saving of user data
	 * @param  Request $request
	 * @return redirect
	 */
	public function postEdit(Request $request, $user_id)
	{
		if ($user_id == Auth::user()->id || !Auth::user()->isGlobalAdmin()) {
			abort(401);
		}

		// Don't allow non global admins to send a type of global admin
		if ($request->type == 'global-admin' && !Auth::user()->isGlobalAdmin()) {
			abort(401);
		}

		$this->validate($request, [
			'first_name'       => 'required|string',
			'last_name'        => 'required|string',
			'email'            => 'required|email',
			'password'         => '',
			'type'             => 'required|in:rider,fitter,global-admin',
			'company'          => 'required_if:type,fitter',
			'is_company_admin' => '',
		]);

		$user = User::findOrFail($user_id);

		$user->first_name       = $request->first_name;
		$user->last_name        = $request->last_name;
		$user->email            = $request->email;
		$user->type             = $request->type;
		$user->password 		= Hash::make($request->get('password'));
		$user->company_id       = $request->get('company', null);
		$user->is_company_admin = $request->get('is_company_admin', 0);

		if ($request->password) {
			$user->password = bcrypt($request->password);
		}

		$user->save();

		return redirect('/global-admin/users')->with('message', 'User successfully edited.');
	}

	/**
	 * Show create user form
	 * @return view
	 */
	public function getCreate()
	{
		$companies = Company::all();

		return view('pages.global-admin.users-create')
			->with('title', 'Create User')
			->with('companies', $companies);
	}

	/**
	 * Handle saving of user data
	 * @param  Request $request
	 * @return redirect
	 */
	public function postCreate(Request $request)
	{
		$this->validate($request, [
			'first_name' 			=> 'required|string',
			'last_name' 			=> 'required|string',
			'email'					=> 'required|email',
			'password' 				=> 'required|confirmed',
			'type'					=> 'required|',
			'company'          		=> 'required_if:type,fitter',
			'is_company_admin' 		=> '',
		]);

		$user = new User();

		$user->first_name       = $request->first_name;
		$user->last_name        = $request->last_name;
		$user->email            = $request->email;
		$user->password         = Hash::make($request->password);
		$user->type             = $request->type;
		$user->company_id       = $request->get('company', null);
		$user->is_company_admin = $request->get('is_company_admin', 0);

		$user->save();

		return redirect('/global-admin/users')->with('message', 'User successfully created.');
	}

	public function getDelete($user_id)
	{
		$user = User::findOrFail($user_id);

		return view('modals.global-admin.users-delete')
			->with('user', $user);
	}

	public function postDelete(Request $request, $user_id)
	{
		$user = User::findOrFail($user_id);

		$user->delete();
	}

}