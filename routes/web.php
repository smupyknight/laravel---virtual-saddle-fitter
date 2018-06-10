<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
	return redirect('/login');
});

Auth::routes();

Route::get('/invitations/accept/{token}', 'InvitationsController@getAccept');
Route::post('/invitations/accept/{token}', 'InvitationsController@postAccept');

Route::get('drawings/{id}', ['as' => 'drawing-image', 'uses' => 'DrawingsController@show']);

// All logged in users
Route::group(['middleware' => ['auth']], function () {
	// Global-Admins only
	Route::group(['middleware' => ['admin'], 'prefix' => 'global-admin', 'namespace' => 'GlobalAdmin'], function () {
		Route::get('/dashboard', 'DashboardController@index');

		// Global-Admins / fitters
		Route::get('/fitters', 'FittersController@getIndex');
		Route::get('/fitters/create', 'FittersController@getCreate');
		Route::post('/fitters/create', 'FittersController@postCreate');
		Route::get('/fitters/view/{id}', 'FittersController@getView');
		Route::get('/fitters/edit/{id}', 'FittersController@getEdit');
		Route::post('/fitters/edit/{id}', 'FittersController@postEdit');
		Route::get('/fitters/delete/{id}', 'FittersController@getDelete');
		Route::post('/fitters/delete/{id}', 'FittersController@postDelete');
		Route::get('/fitters/create-user-modal/{id}', 'FittersController@getCreateUserModal');
		Route::post('/fitters/create-user-modal/{id}', 'FittersController@postCreateUserModal');
		Route::get('/fitters/add-user-modal/{id}', 'FittersController@getAddUserModal');
		Route::post('/fitters/add-user-modal/{id}', 'FittersController@postAddUserModal');
		Route::get('/fitters/delete-user-modal/{fitterId}/{userId}', 'FittersController@getDeleteUserModal');
		Route::post('/fitters/delete-user-modal/{fitterId}/{userId}', 'FittersController@postDeleteUserModal');

		// ***Old Version Migrated*** Global-Admins / Users
		Route::get('/users', 'UsersController@getIndex');
		Route::get('/users/view/{id}', 'UsersController@getView');
		Route::get('/users/edit/{id}', 'UsersController@getEdit');
		Route::post('/users/edit/{id}', 'UsersController@postEdit');
		Route::get('/users/create', 'UsersController@getCreate');
		Route::post('/users/create', 'UsersController@postCreate');
		Route::get('/users/delete/{id}', 'UsersController@getDelete');
		Route::post('/users/delete/{id}', 'UsersController@postDelete');

		// ***Old Version Migrated*** Global-Admins / Brands
		Route::get('/brands', 'BrandsController@getIndex');
		Route::get('/brands/create', 'BrandsController@getCreate');
		Route::post('/brands/create', 'BrandsController@postCreate');
		Route::get('/brands/delete/{id}', 'BrandsController@getDelete');
		Route::post('/brands/delete/{id}', 'BrandsController@postDelete');
		Route::get('/brands/edit/{id}', 'BrandsController@getEdit');
		Route::post('/brands/edit/{id}', 'BrandsController@postEdit');

		// ***Old Version Migrated*** Global-Admins / Styles
		Route::get('/styles', 'StylesController@getIndex');
		Route::get('/styles/create', 'StylesController@getCreate');
		Route::post('/styles/create', 'StylesController@postCreate');
		Route::get('/styles/delete/{id}', 'StylesController@getDelete');
		Route::post('/styles/delete/{id}', 'StylesController@postDelete');
		Route::get('/styles/edit/{id}', 'StylesController@getEdit');
		Route::post('/styles/edit/{id}', 'StylesController@postEdit');
	});

	// Fitter Users only
	Route::group(['middleware' => ['fitter'], 'prefix' => 'admin', 'namespace' => 'Admin'], function () {
		Route::get('/dashboard', function () {
			return view('pages.admin.dashboard');
		});

		Route::get('/horses', function () {
			return view('pages.admin.horses', [
				'title' => 'Horses',
			]);
		});

		Route::get('/clients', function () {
			return view('pages.admin.clients', [
				'title' => 'Clients',
			]);
		});

		Route::get('/riders', function () {
			return view('pages.admin.riders', [
				'title' => 'Riders',
			]);
		});

		Route::get('/saddles', function () {
			return view('pages.admin.saddles', [
				'title' => 'Saddles',
			]);
		});

		Route::get('/bookings', function () {
			return view('pages.admin.bookings', [
				'title' => 'Bookings',
			]);
		});

		Route::get('/fitchecks', function () {
			return view('pages.admin.fitchecks', [
				'title' => 'Fit Checks',
			]);
		});
	});

	// Client Users only
	Route::group(['middleware' => ['client'],  'prefix' => 'client', 'namespace' => 'Client'], function () {
		Route::get('/dashboard', function () {
			return view('pages.client.dashboard');
		});

		Route::get('/horses', function () {
			return view('pages.client.horses', [
				'title' => 'My Horses',
			]);
		});

		Route::get('/my-fitters', function () {
			return view('pages.client.my-fitters', [
				'title' => 'My Fitters',
			]);
		});

		Route::get('/bookings', function () {
			return view('pages.client.bookings', [
				'title' => 'Bookings',
			]);
		});

		Route::get('/riders', function () {
			return view('pages.client.riders', [
				'title' => 'My Riders',
			]);
		});
	});
});
