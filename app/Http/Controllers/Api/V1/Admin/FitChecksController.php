<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFitCheck;
use Illuminate\Http\Request;

use Auth;
use App\FitCheck;
use App\Saddle;
use App\Brand;
use App\Style;

class FitChecksController extends Controller
{

	public function index(Request $request)
	{
		$query = Auth::user()->fitter->fitchecks();

		if ($request->horse) {
			$query->where('horse_id', $request->horse);
		}

		if ($request->rider) {
			$query->where('rider_id', $request->rider);
		}

		if ($request->saddle) {
			$query->where('saddle_id', $request->saddle);
		}

		if ($request->user) {
			$query->where('user_id', $request->user);
		}

		$fitchecks = $query->orderBy('id', 'asc')->paginate($request->get('per_page', 25));

		$data = [];

		foreach ($fitchecks as $fitcheck) {
			$data[] = [
				'id'         => $fitcheck->id,
				'rider'      => [
					'id'         => $fitcheck->rider->id,
					'first_name' => $fitcheck->rider->first_name,
					'last_name'  => $fitcheck->rider->last_name,
				],
				'horse'      => [
					'id'          => $fitcheck->horse->id,
					'stable_name' => $fitcheck->horse->stable_name,
				],
				'saddle'     => [
					'id'   => $fitcheck->saddle->id,
					'name' => $fitcheck->saddle->name,
				],
				'user'       => [
					'id'         => $fitcheck->user->id,
					'first_name' => $fitcheck->user->first_name,
					'last_name'  => $fitcheck->user->last_name,
				],
				'created_at' => $fitcheck->created_at->format('d/m/Y'),
				'updated_at' => $fitcheck->updated_at->format('d/m/Y'),
			];
		}

		$result = [
			'total'         => $fitchecks->total(),
			'per_page'      => $fitchecks->perPage(),
			'current_page'  => $fitchecks->currentPage(),
			'last_page'     => $fitchecks->lastPage(),
			'next_page_url' => $fitchecks->nextPageUrl(),
			'prev_page_url' => $fitchecks->previousPageUrl(),
			'from'          => $fitchecks->firstItem(),
			'to'            => $fitchecks->lastItem(),
			'data'          => $data,
		];

		return response()->json($result);
	}

	public function get($id)
	{
		$fitcheck = FitCheck::findOrFail($id);

		$data = [
			'rider'      => $fitcheck->rider,
			'horse'      => $fitcheck->horse,
			'saddle'     => $fitcheck->saddle,
			'drawing'     => $fitcheck->drawingfile->first(),
			'field_data' => $fitcheck->field_data,
		];

		return response()->json($data);
	}

	public function post(StoreFitCheck $request)
	{
		$fitcheck = new FitCheck;

		$fitcheck->rider_id = $request->rider_id;
		$fitcheck->horse_id = $request->horse_id;

		$brand = Brand::first();
		if (!$brand) {
			return response()
				->json([
					'brand' => ['There is no brand defined yet.'],
				], 404);
		}

		$style = Style::first();
		if (!$style) {
			return response()
				->json([
					'style' => ['There is no style defined yet.'],
				], 404);
		}

		if (!empty($request->saddle_id)) {
			$saddle = Saddle::findOrFail($request->saddle_id);
			$saddle->rider_id = $request->rider_id;
			$saddle->horse_id = $request->horse_id;
			$saddle->save();
		} else {
			$saddle = Saddle::Create([
				'rider_id' => $request->rider_id,
				'horse_id' => $request->horse_id,
				'brand_id' => $brand->id,
				'style_id' => $style->id,
			]);
		}

		$fitcheck->saddle_id = $saddle->id;
		$fitcheck->user_id = Auth::id();

		// Back Assessment
		$fitcheck->setBackLengthAttribute($request->get('back_length', ''));
		$fitcheck->setwitherTemplateAttribute($request->get('wither_template', ''));
		$fitcheck->setWitherShapeAttribute($request->get('wither_shape', ''));
		$fitcheck->setBackTypeAttribute($request->get('back_type', ''));
		$fitcheck->setShoulderAttribute($request->get('shoulder', []));
		$fitcheck->setAbdomenAttribute($request->get('abdomen', ''));
		$fitcheck->setFatCoverAttribute($request->get('fat_cover', ''));
		$fitcheck->setMusclingAttribute($request->get('muscling', ''));

		// Saddle Balance
		$fitcheck->setBackAngleAttribute($request->get('back_angle', ''));
		$fitcheck->setPointOfHipTuberCoxaeAttribute($request->get('point_of_hip_tuber_coxae', ''));
		$fitcheck->setGirthPositionAttribute($request->get('girth_position', ''));

		// Back Problems
		$fitcheck->setMuscleWastageAttribute($request->get('muscle_wastage', []));
		$fitcheck->setSorenessAttribute($request->get('soreness', []));
		$fitcheck->setReducedFlexibilityAttribute($request->get('reduced_flexibility', []));
		$fitcheck->setHairChangesAttribute($request->get('hair_changes', []));
		$fitcheck->setPalationFindingsAttribute($request->get('palation_findings', []));

		// Feet Observation
		$fitcheck->setFootProblemsAttribute($request->get('foot_problems', []));
		$fitcheck->setFeetLengthAttribute($request->get('feet_length', ''));
		$fitcheck->setHeelBalanceAttribute($request->get('heel_balance', ''));
		$fitcheck->setFootBalanceAttribute($request->get('foot_balance', ''));
		$fitcheck->setShoeingStatusAttribute($request->get('shoeing_status', ''));

		// Movement & Behaviour Observation
		$fitcheck->setMovementWhenSaddledAttribute($request->get('movement_when_saddled', []));
		$fitcheck->setMovementWhenSaddledNoRiderAttribute($request->get('movement_when_saddled_no_rider', []));
		$fitcheck->setMovementWhenRiddenAttribute($request->get('movement_when_ridden', []));

		// Saddle Fit
		$fitcheck->setSaddleBalanceAttribute($request->get('saddle_balance', ''));
		$fitcheck->setPommelClearanceAttribute($request->get('pommel_clearance', ''));
		$fitcheck->setSaddleLengthAttribute($request->get('saddle_length', ''));
		$fitcheck->setTreeMatchAtWitherAttribute($request->get('tree_match_at_wither', ''));
		$fitcheck->setTreeMatchAtArcOfSpineAttribute($request->get('tree_match_at_arc_of_spine', ''));
		$fitcheck->setChannelDepthAttribute($request->get('channel_depth', ''));
		$fitcheck->setChannelWidthAttribute($request->get('channel_width', ''));
		$fitcheck->setSaddleTiltAttribute($request->get('saddle_tilt', false));
		$fitcheck->setSaddleTwistAttribute($request->get('saddle_twist', false));
		$fitcheck->setContoursOfPanelAttribute($request->get('contours_of_panel', ''));
		$fitcheck->setGirthPointAngleAttribute($request->get('girth_point_angle', ''));
		$fitcheck->setGirthPointPositionAttribute($request->get('girth_point_position', ''));
		$fitcheck->setGirthTypeAttribute($request->get('girth_type', ''));
		$fitcheck->setGirthSizeAttribute($request->get('girth_size', ''));

		// Rider In Saddle
		$fitcheck->setDropsToAttribute($request->get('drops_to', ''));
		$fitcheck->setSitsOffCentreAttribute($request->get('sits_off_centre', ''));
		$fitcheck->setSitsUprightAttribute($request->get('sits_upright', false));

		// Rider In Saddle
		$fitcheck->setFlockingFrontAttribute($request->get('flocking_front', false));
		$fitcheck->setFlockingMiddleAttribute($request->get('flocking_middle', false));
		$fitcheck->setFlockingBackAttribute($request->get('flocking_back', false));
		$fitcheck->setAlterationsAttribute($request->get('alterations', []));
		$fitcheck->setHistoryOfAlterationsAttribute($request->get('history_of_alterations', []));
		$fitcheck->setRecommendedProductsAttribute($request->get('recommended_products', []));

		$fitcheck->field_data = $fitcheck->data;

		$fitcheck->save();

		return response()
			->json([
				'success' => true,
				'id'      => $fitcheck->id,
			]);
	}

	public function put(StoreFitCheck $request, $id)
	{
		$fitcheck = FitCheck::findOrfail($id);

		$fitcheck->rider_id = $request->rider_id;
		$fitcheck->horse_id = $request->horse_id;
		$fitcheck->saddle_id = $request->saddle_id;
		$fitcheck->user_id = Auth::id();

		// Back Assessment
		$fitcheck->setBackLengthAttribute($request->get('back_length', ''));
		$fitcheck->setwitherTemplateAttribute($request->get('wither_template', ''));
		$fitcheck->setWitherShapeAttribute($request->get('wither_shape', ''));
		$fitcheck->setBackTypeAttribute($request->get('back_type', ''));
		$fitcheck->setShoulderAttribute($request->get('shoulder', []));
		$fitcheck->setAbdomenAttribute($request->get('abdomen', ''));
		$fitcheck->setFatCoverAttribute($request->get('fat_cover', ''));
		$fitcheck->setMusclingAttribute($request->get('muscling', ''));

		// Saddle Balance
		$fitcheck->setBackAngleAttribute($request->get('back_angle', ''));
		$fitcheck->setPointOfHipTuberCoxaeAttribute($request->get('point_of_hip_tuber_coxae', ''));
		$fitcheck->setGirthPositionAttribute($request->get('girth_position', ''));

		// Back Problems
		$fitcheck->setMuscleWastageAttribute($request->get('muscle_wastage', []));
		$fitcheck->setSorenessAttribute($request->get('soreness', []));
		$fitcheck->setReducedFlexibilityAttribute($request->get('reduced_flexibility', []));
		$fitcheck->setHairChangesAttribute($request->get('hair_changes', []));
		$fitcheck->setPalationFindingsAttribute($request->get('palation_findings', []));

		// Feet Observation
		$fitcheck->setFootProblemsAttribute($request->get('foot_problems', []));
		$fitcheck->setFeetLengthAttribute($request->get('feet_length', ''));
		$fitcheck->setHeelBalanceAttribute($request->get('heel_balance', ''));
		$fitcheck->setFootBalanceAttribute($request->get('foot_balance', ''));
		$fitcheck->setShoeingStatusAttribute($request->get('shoeing_status', ''));

		// Movement & Behaviour Observation
		$fitcheck->setMovementWhenSaddledAttribute($request->get('movement_when_saddled', []));
		$fitcheck->setMovementWhenSaddledNoRiderAttribute($request->get('movement_when_saddled_no_rider', []));
		$fitcheck->setMovementWhenRiddenAttribute($request->get('movement_when_ridden', []));

		// Saddle Fit
		$fitcheck->setSaddleBalanceAttribute($request->get('saddle_balance', ''));
		$fitcheck->setPommelClearanceAttribute($request->get('pommel_clearance', ''));
		$fitcheck->setSaddleLengthAttribute($request->get('saddle_length', ''));
		$fitcheck->setTreeMatchAtWitherAttribute($request->get('tree_match_at_wither', ''));
		$fitcheck->setTreeMatchAtArcOfSpineAttribute($request->get('tree_match_at_arc_of_spine', ''));
		$fitcheck->setChannelDepthAttribute($request->get('channel_depth', ''));
		$fitcheck->setChannelWidthAttribute($request->get('channel_width', ''));
		$fitcheck->setSaddleTiltAttribute($request->get('saddle_tilt', false));
		$fitcheck->setSaddleTwistAttribute($request->get('saddle_twist', false));
		$fitcheck->setContoursOfPanelAttribute($request->get('contours_of_panel', ''));
		$fitcheck->setGirthPointAngleAttribute($request->get('girth_point_angle', ''));
		$fitcheck->setGirthPointPositionAttribute($request->get('girth_point_position', ''));
		$fitcheck->setGirthTypeAttribute($request->get('girth_type', ''));
		$fitcheck->setGirthSizeAttribute($request->get('girth_size', ''));

		// Rider In Saddle
		$fitcheck->setDropsToAttribute($request->get('drops_to', ''));
		$fitcheck->setSitsOffCentreAttribute($request->get('sits_off_centre', ''));
		$fitcheck->setSitsUprightAttribute($request->get('sits_upright', false));

		// Rider In Saddle
		$fitcheck->setFlockingFrontAttribute($request->get('flocking_front', false));
		$fitcheck->setFlockingMiddleAttribute($request->get('flocking_middle', false));
		$fitcheck->setFlockingBackAttribute($request->get('flocking_back', false));
		$fitcheck->setAlterationsAttribute($request->get('alterations', []));
		$fitcheck->setHistoryOfAlterationsAttribute($request->get('history_of_alterations', []));
		$fitcheck->setRecommendedProductsAttribute($request->get('recommended_products', []));

		$fitcheck->field_data = $fitcheck->data;

		$fitcheck->save();

		return response()
			->json([
				'success' => true,
				'id'      => $fitcheck->id,
			]);
	}

	public function delete($id)
	{
		$fitcheck = FitCheck::findOrFail($id);
		$fitcheck->delete();

		return response()->json(['success' => true]);
	}

}
