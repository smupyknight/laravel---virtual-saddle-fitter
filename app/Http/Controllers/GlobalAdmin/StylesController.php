<?php

namespace App\Http\Controllers\GlobalAdmin;

use Illuminate\Http\Request;
use App\Style;
use App\Brand;

class StylesController extends \App\Http\Controllers\Controller
{

	/**
	 * Show a list of brands.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function getIndex(Request $request)
	{
		$styles = Style::paginate($request->get('per_page', 25));

		return view('pages.global-admin.styles-list')
			->with('styles', $styles)
			->with('title', 'Styles List');
	}

	/**
	 * Handle the creation of styles
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function getCreate()
	{
		$brands = Brand::all();

		return view('pages.global-admin.styles-create')
			->with('brands', $brands)
			->with('title', 'Create Style');
	}

	/**
	 * Handle the saving of style data
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function postCreate(Request $request)
	{
		$this->validate($request, [
			'brand' => 'required|',
			'name' 	=> 'required|',
		]);

		$style = new Style();

		$style->brand_id	= $request->brand;
		$style->name 		= $request->name;

		$style->save();

		return redirect('/global-admin/styles')->with('message', 'Style successfully created.');
	}

	public function getDelete($style_id)
	{
		$style = Style::findOrFail($style_id);

		return view('modals.global-admin.styles-delete')
			->with('style', $style);
	}

	public function getEdit($style_id)
	{
		$style = Style::findOrFail($style_id);

		return view('modals.global-admin.styles-edit')
			->with('style', $style);
	}

	public function postDelete(Request $request, $style_id)
	{
		$style = Style::findOrFail($style_id);

		$style->delete();
	}

	public function postEdit(Request $request, $style_id)
	{
		$this->validate($request, [
			'name' => 'string',
		]);

		$style = Style::findOrFail($style_id);

		$style->name = $request->get('name');

		$style->save();
	}

}
