<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;
use DB;
use App\FitCheck;
use Carbon\Carbon;

class FitChecksService
{

	public function create(Request $request)
	{
		$this->validate($request, [
			'horse'                        => 'required',
			'saddle'                       => 'required',
			'pommel_clearance'             => 'required',
			'tree_match_at_wither'         => 'required',
			'tree_match_with_arc_of_spine' => 'required',
			'cause'                        => 'required',
			'channel_depth'                => 'required',
			'channel_width'                => 'required',
			'tilt_to_side_from_rear'       => 'required',
			'twist_in_saddle_from_side'    => 'required',
			'panel_contours'               => 'required',
			'horse_motion_no_rider'        => 'required',
			'rider_drops'                  => 'required',
			'rider_sit_off_centre'         => 'required',
			'rider_sits'                   => 'required',
			'comments'                     => 'required',
			'alterations_required'         => 'required',
		], [
			'horse.required'  => 'You must select a horse.',
			'saddle.required' => 'You must select a saddle',
		]);

		$user = $request->api_token ? Auth::guard('api')->user() : Auth::user();

		$fitcheck = new FitCheck;

		$fitcheck->horse_id                     = $request->horse;
		$fitcheck->saddle_id                    = $request->saddle;
		$fitcheck->pommel_clearance             = $request->pommel_clearance;
		$fitcheck->tree_match_at_wither         = $request->tree_match_at_wither;
		$fitcheck->tree_match_with_arc_of_spine = $request->tree_match_with_arc_of_spine;
		$fitcheck->cause                        = $request->cause;
		$fitcheck->channel_depth                = $request->channel_depth;
		$fitcheck->channel_width                = $request->channel_width;
		$fitcheck->tilt_to_side_from_rear       = $request->tilt_to_side_from_rear;
		$fitcheck->twist_in_saddle_from_side    = $request->twist_in_saddle_from_side;
		$fitcheck->panel_contours               = $request->panel_contours;
		$fitcheck->horse_motion_no_rider        = $request->horse_motion_no_rider;
		$fitcheck->rider_drops                  = $request->rider_drops;
		$fitcheck->rider_sits                   = $request->rider_sits;
		$fitcheck->comments                     = $request->comments;
		$fitcheck->alterations_required         = $request->alterations_required;

		$fitcheck->save();

		return $fitcheck;
	}

	public function test(Request $request)
	{
		return $request->message;
	}

	public function edit(Request $request)
	{
	}

	public function delete(Request $request)
	{
	}

}
