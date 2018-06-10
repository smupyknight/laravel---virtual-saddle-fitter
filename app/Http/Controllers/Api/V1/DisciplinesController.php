<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Discipline;

class DisciplinesController extends Controller
{

	public function index()
	{
		$disciplines = Discipline::ALL;

		return response()
			->json($disciplines);
	}

}
