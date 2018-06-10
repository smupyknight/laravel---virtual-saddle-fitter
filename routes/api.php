<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'v1', 'namespace' => 'Api\V1'], function () {
	Route::middleware('auth:api')->get('/user', function (Request $request) {
		$user = Auth::user();
		$client = $user->client;
		$fitter = $user->fitter;

		return response()
			->json([
				'user'   => $request->user(),
				'client' => $client ? $client->toArray() : null,
				'fitter' => $fitter ? $fitter->toArray() : null,
			]);
	});

	// Public APIs.
	Route::post('auth/login', 'AuthController@postLogin');
	Route::post('auth/register', 'AuthController@postRegister');

	// Fitter users APIs.
	Route::group(['middleware' => ['auth:api', 'fitter'], 'namespace' => 'Admin', 'prefix' => 'admin'], function () {
		// Clients Resource.
		Route::get('clients', 'ClientsController@index');
		Route::post('clients', 'ClientsController@post');
		Route::post('clients/create', 'ClientsController@post');
		Route::get('clients/{id}', 'ClientsController@get');
		Route::put('clients/{id}', 'ClientsController@put');
		Route::delete('clients/{id}', 'ClientsController@delete');
		Route::get('clients/{id}/get-user/{userId}', 'ClientsController@getUser');
		Route::post('clients/{id}/invite-user', 'ClientsController@postInviteUser');
		Route::post('clients/{id}/create-user', 'ClientsController@postCreateUser');
		Route::put('clients/{id}/put-user/{userId}', 'ClientsController@putUpdateUser');
		Route::delete('clients/{id}/delete-user/{userId}', 'ClientsController@deleteUser');

		// Horses Resource.
		Route::get('/horses', 'HorsesController@getIndex');
		Route::get('/horses/{id}', 'HorsesController@getView');
		Route::post('/horses', 'HorsesController@postCreate');
		Route::post('/horses/create', 'HorsesController@postCreate');
		Route::put('/horses/{id}', 'HorsesController@put');
		Route::delete('/horses/{id}', 'HorsesController@delete');

		// Riders Resource.
		Route::get('riders', 'RidersController@index');
		Route::post('riders', 'RidersController@post');
		Route::post('riders/create', 'RidersController@post');
		Route::get('riders/{id}', 'RidersController@get');
		Route::put('riders/{id}', 'RidersController@put');
		Route::delete('riders/{id}', 'RidersController@delete');

		// FitChecks Resource.
		Route::get('/fitchecks', 'FitChecksController@index');
		Route::post('/fitchecks', 'FitChecksController@post');
		Route::post('/fitchecks/create', 'FitChecksController@post');
		Route::get('/fitchecks/{id}', 'FitChecksController@get');
		Route::put('/fitchecks/{id}', 'FitChecksController@put');
		Route::delete('/fitchecks/{id}', 'FitChecksController@delete');

		// Saddles Resource.
		Route::get('/saddles', 'SaddlesController@getIndex');
		Route::post('/saddles', 'SaddlesController@postCreate');
		Route::get('/saddles/create', 'SaddlesController@getCreate');
		Route::post('/saddles/create', 'SaddlesController@postCreate');
		Route::get('/saddles/{id}', 'SaddlesController@getView');
		Route::put('/saddles/{id}', 'SaddlesController@postEdit');
		Route::delete('/saddles/{id}', 'SaddlesController@delete');

		// Bookings Resource.
		Route::get('bookings', 'BookingsController@index');
		Route::post('bookings', 'BookingsController@post');
		Route::post('bookings/create', 'BookingsController@post');
		Route::get('bookings/{id}', 'BookingsController@get');
		Route::put('bookings/{id}', 'BookingsController@put');
		Route::delete('bookings/{id}', 'BookingsController@delete');

		// Drawings Resource.
		Route::get('/drawings/{id}', 'DrawingsController@get');
		Route::post('/drawings/{id}', 'DrawingsController@post');

		// Only returns my fitter users
		Route::get('/fitters/my-users', 'FittersController@getMyUsers');
		// Returns my fitter admin, users
		Route::get('/fitters/my-users-all', 'FittersController@getMyUsersAll');

		Route::get('/resources', 'ResourcesController@getIndex');
		Route::get('/resources/fitcheck-options', 'ResourcesController@getFitCheckOptions');
	});

	// Client user APIs.
	Route::group(['middleware' => ['auth:api', 'client'], 'namespace' => 'Client', 'prefix' => 'client'], function () {
		// Horses API.
		Route::get('horses', 'HorsesController@index');
		Route::post('horses', 'HorsesController@post');
		Route::post('horses/create', 'HorsesController@post');
		Route::get('horses/{id}', 'HorsesController@get');
		Route::put('horses/{id}', 'HorsesController@put');
		Route::delete('horses/{id}', 'HorsesController@delete');

		// Riders API.
		Route::get('riders', 'RidersController@index');
		Route::post('riders', 'RidersController@post');
		Route::post('riders/create', 'RidersController@post');
		Route::get('riders/{id}', 'RidersController@get');
		Route::put('riders/{id}', 'RidersController@put');
		Route::delete('riders/{id}', 'RidersController@delete');

		// Manage My Fitters API. Relationship between client and fitters.
		Route::get('my-fitters', 'MyFittersController@index');
		Route::post('my-fitters/{id}', 'MyFittersController@postAdd');
		Route::delete('my-fitters/{id}', 'MyFittersController@delete');

		// Bookings API.
		Route::get('bookings', 'BookingsController@index');
		Route::post('bookings', 'BookingsController@post');
		Route::post('bookings/create', 'BookingsController@post');
		Route::get('bookings/{id}', 'BookingsController@get');
		Route::put('bookings/{id}', 'BookingsController@put');
		Route::delete('bookings/{id}', 'BookingsController@delete');
	});

	// Common registered users APIs.
	Route::group(['middleware' => 'auth:api'], function () {
		// Fitter APIs.
		Route::get('fitters', 'FittersController@index');
		Route::get('fitters/{id}', 'FittersController@get');

		// Brands API.
		Route::get('brands', 'BrandsController@index');
		Route::get('brands/{id}', 'BrandsController@get');

		// Disciplines API.
		Route::get('disciplines', 'DisciplinesController@index');

		// Breeds API.
		Route::get('breeds', 'BreedsController@index');
	});
});
