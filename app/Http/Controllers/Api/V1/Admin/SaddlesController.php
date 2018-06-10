<?php

namespace App\Http\Controllers\Api\V1\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Carbon\Carbon;
use App\Saddle;
use Auth;
use Exception;

class SaddlesController extends Controller
{

	public function getIndex(Request $request)
	{
		$query = Auth::user()->fitter->saddles();

		if ($request->horse) {
			$query->where('horse_id', $request->horse);
		}

		$saddles = $query->orderBy('id', 'asc')->paginate($request->get('per_page', 25));

		$data = [];

		foreach ($saddles as $item) {
			$saddle = Saddle::find($item->id);
			$data[] = [
				'id'            => $saddle->id,
				'name'          => $saddle->name,
				'horse'         => [
					'id'          => $saddle->horse->id,
					'stable_name' => $saddle->horse->stable_name,
				],
				'brand'         => [
					'id'   => $saddle->brand->id,
					'name' => $saddle->brand->name,
				],
				'style'         => [
					'id'   => $saddle->style->id,
					'name' => $saddle->style->name,
				],
				'type'          => $saddle->type,
				'serial_number' => $saddle->serial_number,
				'created_at'    => $saddle->created_at->format('d/m/Y'),
			];
		}

		$results = [
			'total'         => $saddles->total(),
			'per_page'      => $saddles->perPage(),
			'current_page'  => $saddles->currentPage(),
			'last_page'     => $saddles->lastPage(),
			'next_page_url' => $saddles->nextPageUrl(),
			'prev_page_url' => $saddles->previousPageUrl(),
			'from'          => $saddles->firstItem(),
			'to'            => $saddles->lastItem(),
			'data'          => $data,
		];

		return response()->json($results);
	}

	public function getView($saddle_id)
	{
		$saddle = Saddle::findOrFail($saddle_id);

		$data_array = $saddle->toArray();
		$data_array['purchased_at'] = $saddle->purchased_at ? $saddle->purchased_at->format('d/m/Y') : '';
		$data_array['rider'] = [
			'id'         => $saddle->rider ? $saddle->rider->id : '',
			'first_name' => $saddle->rider ? $saddle->rider->first_name : '',
			'last_name'  => $saddle->rider ? $saddle->rider->last_name : '',
		];
		$data_array['horse'] = [
			'id'          => $saddle->horse ? $saddle->horse->id : '',
			'stable_name' => $saddle->horse ? $saddle->horse->stable_name : '',
		];
		$data_array['brand'] = [
			'id'   => $saddle->brand ? $saddle->brand->id : '',
			'name' => $saddle->brand ? $saddle->brand->name : '',
		];
		$data_array['style'] = [
			'id'   => $saddle->style ? $saddle->style->id : '',
			'name' => $saddle->style ? $saddle->style->name : '',
		];

		return response()->json($data_array);
	}

	public function getCreate()
	{
		$saddle = new Saddle;
		$data_array = $saddle->toArray();

		return response()->json($data_array);
	}

	public function postCreate(Request $request)
	{
		$this->validate($request, [
			'rider_id'        => '',
			'horse_id'        => 'required|exists:horses,id',
			'brand_id'        => 'required|exists:brands,id',
			'style_id'        => 'required|exists:styles,id,brand_id,' . $request->brand_id,
			'name'            => 'required',
			'price'           => 'numeric|min:0|max:1000',
			'serial_number'   => 'required',
			'size'            => 'required',
			'type'            => 'required|in:All Purpose,Dressage,Endurance,Eventing,Icelandic,Jump,Pony,Show,Special,Stock,Trekking,Western',
			'gullet_size'     => 'required|in:XXW,XW/XXW,XW,W/XW,W,M/W,M,N/M,N',
			'panel_type'      => 'required|in:Flock,Cair,Flair,Foam,Felt,Latex',
			'seat_style'      => 'in:Deep seat,Standard,Flat seat',
			'purchased_at'    => 'required|date_Format:d/m/Y',
			'warranty_period' => '',
		]);

		$saddle = new Saddle;

		$saddle->rider_id = $request->rider_id;
		$saddle->horse_id = $request->horse_id;
		$saddle->brand_id = $request->brand_id;
		$saddle->style_id = $request->style_id;
		$saddle->name = $request->name;
		$saddle->price = $request->price;
		$saddle->serial_number = $request->serial_number;
		$saddle->size = $request->size;
		$saddle->type = $request->type;
		$saddle->gullet_size = $request->gullet_size;
		$saddle->panel_type = $request->panel_type;
		$saddle->seat_style = $request->seat_style;
		$saddle->purchased_at = $request->purchased_at ? Carbon::createFromFormat('d/m/Y', $request->purchased_at) : '';
		$saddle->warranty_period = $request->warranty_period;

		$saddle->save();

		return response()->json(['id' => $saddle->id]);
	}

	public function postEdit(Request $request, $saddle_id)
	{
		$this->validate($request, [
			'rider_id'        => '',
			'horse_id'        => 'required|exists:horses,id',
			'brand_id'        => 'required|exists:brands,id',
			'style_id'        => 'required|exists:styles,id,brand_id,' . $request->brand_id,
			'name'            => 'required',
			'price'           => 'numeric|min:0|max:1000',
			'serial_number'   => 'required',
			'size'            => 'required',
			'type'            => 'required|in:All Purpose,Dressage,Endurance,Eventing,Icelandic,Jump,Pony,Show,Special,Stock,Trekking,Western',
			'gullet_size'     => 'required|in:XXW,XW/XXW,XW,W/XW,W,M/W,M,N/M, N',
			'panel_type'      => 'required|in:Flock,Cair,Flair,Foam,Felt,Latex',
			'seat_style'      => 'in:Deep seat,Standard,Flat seat',
			'purchased_at'    => 'required|date_Format:d/m/Y',
			'warranty_period' => '',
		]);

		$saddle = Saddle::findOrFail($saddle_id);

		$saddle->rider_id = $request->rider_id;
		$saddle->horse_id = $request->horse_id;
		$saddle->brand_id = $request->brand_id;
		$saddle->style_id = $request->style_id;
		$saddle->name = $request->name;
		$saddle->price = $request->price;
		$saddle->serial_number = $request->serial_number;
		$saddle->size = $request->size;
		$saddle->type = $request->type;
		$saddle->gullet_size = $request->gullet_size;
		$saddle->panel_type = $request->panel_type;
		$saddle->seat_style = $request->seat_style;
		$saddle->purchased_at = $request->purchased_at ? Carbon::createFromFormat('d/m/Y', $request->purchased_at) : '';
		$saddle->warranty_period = $request->warranty_period;

		$saddle->save();

		return response()->json(['id' => $saddle->id]);
	}

	public function delete(Request $request, $id)
	{
		$saddle = Saddle::findOrFail($id);

		// Check safety
		$errors = [];

		// Check if related to any fitchecks.
		$fitchecks = [];
		foreach ($saddle->fitchecks as $fitcheck) {
			$fitchecks[] = $fitcheck->id;
		}

		if (count($fitchecks)) {
			$errors['fitchecks'] = 'Related fitcheck ids: ' . implode(',', $fitchecks);
		}

		// Return error
		if (count($errors)) {
			return response()
				->json(array_merge([
					'error' => 'This Saddle is related with other entities!',
				], $errors), 422);
		}

		$saddle->delete();

		return response()
			->json([
				'success' => true,
			]);
	}

}
