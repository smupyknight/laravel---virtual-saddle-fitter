<?php

namespace App\Http\Controllers\Api\V1\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Discipline;
use App\Horse;
use App\Breed;
use App\Brand;
use App\Style;
use App\Type;
use App\FitCheck;
use Auth;

class ResourcesController extends Controller
{

	public function getIndex()
	{
		$styles = Style::all();
		$colours = Horse::COLOURS;
		$breeds = Breed::all();
		$disciplines = Discipline::ALL;

		$_styles = [];
		$_colours = [];
		$_breeds = [];
		$_disciplines = [];

		foreach ($styles as $style) {
			$_styles[] = [
				'id'         => $style->id,
				'name'       => $style->name,
				'brand_id'   => $style->brand->id,
				'brand_name' => $style->brand->name,
				'type_id'    => $style->type->id,
				'type_name'  => $style->type->name,
			];
		}

		foreach ($colours as $colour) {
			$_colours[] = $colour;
		}

		foreach ($breeds as $breed) {
			$_breeds[] = [
				'id'   => $breed->id,
				'name' => $breed->name,
			];
		}

		$_disciplines = $disciplines;

		$data = [
			'styles'      => $_styles,
			'colours'     => $_colours,
			'breeds'      => $_breeds,
			'disciplines' => $_disciplines,
		];

		return response()->json($data);
	}

	public function getFitCheckOptions()
	{
		return response()->json(['fitcheck-options' => Fitcheck::OPTIONS]);
	}

}