<?php

namespace App\Http\Controllers\GlobalAdmin;

use Illuminate\Http\Request;
use App\Brand;
use Auth;

class BrandsController extends \App\Http\Controllers\Controller
{

	/**
	 * Show a list of brands.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function getIndex(Request $request)
	{
		$brands = Brand::paginate($request->get('per_page', 25));

		if ($request->phrase) {
			$brands->where('name', 'like', '%' . $request->phrase . '%');
		}

		return view('pages.global-admin.brands-list')
			->with('brands', $brands)
			->with('title', 'Brands List');
	}

	/**
	 * Show create brand form
	 * @return view
	 */
	public function getCreate()
	{
		return view('pages.global-admin.brands-create')
			->with('title', 'Create Brand');
	}

	public function postCreate(Request $request)
	{
		$this->validate($request, [
			'names' => 'required|',
		]);

		$names = explode(', ', $request->names);

		foreach ($names as $name) {
			$brand = new Brand();

			$brand->name = $name;

			$brand->save();
		}

		return redirect('/global-admin/brands')->with('message', 'Brand successfully added.');
	}

	public function getDelete($brand_id)
	{
		$brand = Brand::findOrFail($brand_id);

		return view('modals.global-admin.brands-delete')
			->with('brand', $brand);
	}

	public function getEdit($brand_id)
	{
		$brand = Brand::findOrFail($brand_id);

		return view('modals.global-admin.brands-edit')
			->with('brand', $brand);
	}

	public function postDelete(Request $request, $brand_id)
	{
		$brand = Brand::findOrFail($brand_id);

		$brand->delete();
	}

	public function postEdit(Request $request, $brand_id)
	{
		$this->validate($request, [
			'name' => 'string',
		]);

		$brand = Brand::findOrFail($brand_id);

		$brand->name = $request->get('name');

		$brand->save();
	}

}