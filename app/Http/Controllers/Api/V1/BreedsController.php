<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Breed;

class BreedsController extends Controller
{

	public function index()
	{
		$breeds = Breed::all();

		return response()
			->json($breeds);
	}

}
