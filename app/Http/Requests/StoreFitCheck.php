<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\FitCheck;

class StoreFitCheck extends FormRequest
{

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'rider_id'                         => 'required',
			'horse_id'                         => 'required',
			'back_length'                      => 'in:' . implode(',', FitCheck::OPTIONS['back_length']),
			'wither_template'                  => '',
			'wither_height'                    => 'in:' . implode(',', FitCheck::OPTIONS['wither_height']),
			'wither_breadth'                   => 'in:' . implode(',', FitCheck::OPTIONS['wither_breadth']),
			'flatness'                         => 'in:' . implode(',', FitCheck::OPTIONS['flatness']),
			'back_type'                        => 'in:' . implode(',', FitCheck::OPTIONS['back_type']),
			'shoulder.*'                       => 'in:' . implode(',', FitCheck::OPTIONS['shoulder']),
			'abdomen'                          => 'in:' . implode(',', FitCheck::OPTIONS['abdomen']),
			'fat_cover'                        => 'required|integer|between:1,6',
			'muscling'                         => 'required|integer|between:1,6',
			'back_angle'                       => 'in:' . implode(',', FitCheck::OPTIONS['back_angle']),
			'point_of_hip_tuber_coxae'         => 'in:' . implode(',', FitCheck::OPTIONS['point_of_hip_tuber_coxae']),
			'girth_position'                   => 'required|in:' . implode(',', FitCheck::OPTIONS['girth_position']),
			'muscle_wastage.*'                 => 'in:' . implode(',', FitCheck::OPTIONS['muscle_wastage']),
			'soreness.*'                       => 'in:' . implode(',', FitCheck::OPTIONS['soreness']),
			'girth_pain'                       => 'in:' . implode(',', FitCheck::OPTIONS['girth_pain']),
			'reduced_flexibility.*'            => 'in:' . implode(',', FitCheck::OPTIONS['reduced_flexibility']),
			'hair_changes.*'                   => 'in:' . implode(',', FitCheck::OPTIONS['hair_changes']),
			'palation_findings.*'              => 'in:' . implode(',', FitCheck::OPTIONS['palation_findings']),
			'foot_problems.*'                  => 'in:' . implode(',', FitCheck::OPTIONS['foot_problems']),
			'feet_length'                      => 'in:' . implode(',', FitCheck::OPTIONS['feet_length']),
			'heel_balance'                     => 'in:' . implode(',', FitCheck::OPTIONS['heel_balance']),
			'foot_balance'                     => 'in:' . implode(',', FitCheck::OPTIONS['foot_balance']),
			'shoeing_status'                   => 'required|in:' . implode(',', FitCheck::OPTIONS['shoeing_status']),
			'movement_when_saddled.*'          => 'in:' . implode(',', FitCheck::OPTIONS['movement_when_saddled']),
			'movement_when_saddled_no_rider.*' => 'in:' . implode(',', FitCheck::OPTIONS['movement_when_saddled_no_rider']),
			'movement_when_ridden.*'           => 'in:' . implode(',', FitCheck::OPTIONS['movement_when_ridden']),
			'saddle_balance'                   => 'required|in:' . implode(',', FitCheck::OPTIONS['saddle_balance']),
			'pommel_clearance'                 => 'required|in:' . implode(',', FitCheck::OPTIONS['pommel_clearance']),
			'saddle_length'                    => 'required|in:' . implode(',', FitCheck::OPTIONS['saddle_length']),
			'tree_match_at_wither'             => 'in:' . implode(',', FitCheck::OPTIONS['tree_match_at_wither']),
			'tree_match_at_arc_of_spine'       => 'required|in:' . implode(',', FitCheck::OPTIONS['tree_match_at_arc_of_spine']),
			'channel_depth'                    => 'required|in:' . implode(',', FitCheck::OPTIONS['channel_depth']),
			'channel_width'                    => 'required|in:' . implode(',', FitCheck::OPTIONS['channel_width']),
			'saddle_tilt'                      => 'boolean',
			'saddle_twist'                     => 'boolean',
			'contours_of_panel'                => 'required|in:' . implode(',', FitCheck::OPTIONS['contours_of_panel']),
			'girth_point_angle'                => 'required|in:' . implode(',', FitCheck::OPTIONS['girth_point_angle']),
			'girth_point_position'             => 'required|in:' . implode(',', FitCheck::OPTIONS['girth_point_position']),
			'girth_type'                       => 'required|in:' . implode(',', FitCheck::OPTIONS['girth_type']),
			'girth_size'                       => 'required',
			'drops_to'                         => 'in:' . implode(',', FitCheck::OPTIONS['drops_to']),
			'sits_off_centre'                  => 'in:' . implode(',', FitCheck::OPTIONS['sits_off_centre']),
			'sits_upright'                     => 'boolean',
			'flocking_front'                   => 'boolean',
			'flocking_middle'                  => 'boolean',
			'flocking_back'                    => 'boolean',
			'alterations.*'                    => '',
			'history_of_alterations.*'         => 'string',
			'recommended_products.*'           => 'string',
		];
	}

}
