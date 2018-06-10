<?php

namespace App\Http\Controllers\GlobalAdmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Fitter;
use App\User;

class FittersController extends \App\Http\Controllers\Controller
{

	public function getIndex(Request $request)
	{
		$query = Fitter::orderBy('id');

		$query->where(function ($query) use ($request) {
			$query->orWhere('name', 'like', '%' . $request->search . '%');
			$query->orWhere('email', 'like', '%' . $request->search . '%');
		});

		return view('pages.global-admin.fitters-list', [
			'title'   => 'All Organisations',
			'fitters' => $query->paginate($request->get('per_page', 25)),
		]);
	}

	public function getCreate(Request $request)
	{
		return view('pages.global-admin.fitters-create', [
			'title' => 'Create New Organisation',
		]);
	}

	public function postCreate(Request $request)
	{
		$this->validate($request, [
			'name'     => 'required|max:255',
			'abn'      => 'required|numeric',
			'phone'    => 'required|max:20|min:6',
			'email'    => 'required|email|max:255|unique:fitters,email',
			'address'  => 'required|string|max:255',
			'suburb'   => 'required|string|max:255',
			'postcode' => 'required|string|max:255',
			'state'    => 'required|string',
			'logo'     => 'required|image',
		]);

		$fitter = Fitter::create([
			'name'     => $request->name,
			'abn'      => $request->abn,
			'phone'    => $request->phone,
			'email'    => $request->email,
			'address'  => $request->address,
			'suburb'   => $request->suburb,
			'postcode' => $request->postcode,
			'state'    => $request->state,
			'logo'     => $request->logo,
		]);

		if ($request->hasFile('logo')) {
			$logo_file = $this->updateLogo($request, $fitter);
			if ($logo_file['success']) {
				$fitter->logo = $logo_file['fitter_logo'];
				$fitter->save();
			}
		}

		return redirect('/global-admin/fitters/view/' . $fitter->id);
	}

	public function getView(Request $request, $id)
	{
		$fitter = Fitter::findOrFail($id);

		$users_query = $fitter->users()->orderBy('id');

		$users_query->where(function ($query) use ($request) {
			$query->orWhere('first_name', 'like', '%' . $request->search_user . '%');
			$query->orWhere('last_name', 'like', '%' . $request->search_user . '%');
			$query->orWhere('email', 'like', '%' . $request->search_user . '%');
		});

		return view('pages.global-admin.fitters-view', [
			'fitter' => $fitter,
			'users'  => $users_query->get(),
			'title'  => 'Details of',
		]);
	}

	public function getEdit(Request $request, $id)
	{
		$fitter = Fitter::findOrFail($id);

		return view('pages.global-admin.fitters-edit', [
			'fitter' => $fitter,
			'title'  => 'Edit ',
		]);
	}

	public function postEdit(Request $request, $id)
	{
		$this->validate($request, [
			'name'     => 'required|max:255',
			'abn'      => 'required|numeric',
			'phone'    => 'required|max:20|min:6',
			'email'    => 'required|email|max:255|unique:fitters,email,' . $id,
			'address'  => 'required|string|max:255',
			'suburb'   => 'required|string|max:255',
			'postcode' => 'required|string|max:255',
			'state'    => 'required|string',
			'logo'     => 'image',
		]);

		$fitter = Fitter::findOrFail($id);

		$fitter->update([
			'name'     => $request->name,
			'abn'      => $request->abn,
			'phone'    => $request->phone,
			'email'    => $request->email,
			'address'  => $request->address,
			'suburb'   => $request->suburb,
			'postcode' => $request->postcode,
			'state'    => $request->state,
		]);

		if ($request->hasFile('logo')) {
			$logo_file = $this->updateLogo($request, $fitter);
			if ($logo_file['success']) {
				$fitter->logo = $logo_file['fitter_logo'];
				$fitter->save();
			}
		}

		return redirect('/global-admin/fitters/view/' . $fitter->id);
	}

	public function getDelete(Request $request, $id)
	{
		$fitter = Fitter::findOrFail($id);

		return view('modals.global-admin.fitters-delete', [
			'fitter' => $fitter,
		]);
	}

	public function postDelete(Request $request, $id)
	{
		$fitter = Fitter::findOrFail($id);
		$fitter->delete();

		return response()
			->json([
				'success' => true,
			], 200);
	}

	public function updateLogo($request, $fitter)
	{
		$result = ['success' => false, 'message' => 'Error: Something went wrong.'];
		try {
			$ext = $request->file('logo')->guessExtension();

			$fitter_logo = 'fitter_' . $fitter->id . '.' . $ext;
			if ($request->file('logo')->move('fitter_logos/', $fitter_logo)) {
				$result = ['success' => true, 'message' => 'File uploaded successfully.', 'fitter_logo' => $fitter_logo];
			}
		} catch (\Exception $e) {
			abort(500);
		}

		return $result;
	}

	public function getCreateUserModal(Request $request, $id)
	{
		$fitter = Fitter::findOrFail($id);

		return view('modals.global-admin.fitters-create-user', [
			'fitter' => $fitter,
		]);
	}

	public function postCreateUserModal(Request $request, $id)
	{
		$fitter = Fitter::findOrFail($id);

		$this->validate($request, [
			'first_name' => 'required|string|max:255',
			'last_name'  => 'required|string|max:255',
			'email'      => 'required|email|unique:users,email|max:255',
			'password'   => 'required|confirmed|min:6|max:255',
			'type'       => 'required|in:fitter-user,fitter-admin',
		]);

		$user = User::create([
			'fitter_id'  => $fitter->id,
			'first_name' => $request->first_name,
			'last_name'  => $request->last_name,
			'email'      => $request->email,
			'password'   => bcrypt($request->password),
			'type'       => $request->type,
		]);

		return response()
			->json([
				'success' => true,
			], 200);
	}

	public function getAddUserModal(Request $request, $id)
	{
		$fitter = Fitter::findOrFail($id);
		$users  = User::where('type', 'fitter-user')
			->orWhere('type', 'fitter-admin')
			->get();

		return view('modals.global-admin.fitters-add-user', [
			'fitter' => $fitter,
			'users'  => $users,
		]);
	}

	public function postAddUserModal(Request $request, $id)
	{
		$this->validate($request, [
			'user_id' => 'required',
			'type'    => 'required|in:fitter-admin,fitter-user',
		]);

		$fitter = Fitter::findOrFail($id);
		$user   = User::findOrFail($request->user_id);

		$user->fitter_id = $fitter->id;
		$user->type      = $request->type;
		$user->save();

		return response()
			->json([
				'success' => true,
			], 200);
	}

	public function getDeleteUserModal(Request $request, $fitterId, $userId)
	{
		$fitter = Fitter::findOrFail($fitterId);
		$user   = User::findOrFail($userId);
		if ($user->fitter_id != $fitterId) {
			return response()
				->json([
					'fitter' => "Fitter doesn't have this user",
				], 422);
		}

		return view('modals.global-admin.fitters-delete-user', [
			'fitter' => $fitter,
			'user'   => $user,
		]);
	}

	public function postDeleteUserModal(Request $request, $fitterId, $userId)
	{
		$user = User::findOrFail($userId);
		if ($user->fitter_id != $fitterId) {
			return response()
				->json([
					'fitter' => "Fitter doesn't have this user",
				], 422);
		}

		$user->delete();

		return response()
			->json([
				'success' => true,
			], 200);
	}

}
