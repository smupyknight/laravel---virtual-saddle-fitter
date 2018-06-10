<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Brand;

class BrandsController extends Controller
{

	public function index(Request $request)
	{
		return response()
			->json(Brand::all());
	}

	public function get(Request $request, $id)
	{
		$brand = Brand::findOrFail($id);
		$styles = $brand->styles;

		$data_array = $brand->toArray();
		$data_array['styles'] = $styles->toArray();

		return response()
			->json($data_array);
	}

}
