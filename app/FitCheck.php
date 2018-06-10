<?php

namespace App;

use App\Http\Requests\StoreFitCheck;
use Illuminate\Database\Eloquent\Model;

class FitCheck extends Model
{

	const OPTIONS = [
		'back_length'                    => ['Short', 'Average', 'Long'],
		'wither_height'                  => ['High', 'Standard', 'Low'],
		'wither_breadth'                 => ['Narrow', 'Wide'],
		'flatness'                       => ['High', 'Standard', 'Low', 'Narrow', 'Wide', 'Flat'],
		'back_type'                      => ['Sway Back', 'Roach', 'Curved', 'Side', 'Flat', 'Rafter'],
		'shoulder'                       => ['Left Higher', 'Right Higher', 'Left Flatter', 'Right Flatter', 'Left Bigger', 'Right Bigger'],
		'abdomen'                        => ['Dropped', 'Neutral', 'Sloped'],

		'back_angle'                     => ['Uphill/High Wither', 'Downhill/Croup High'],
		'point_of_hip_tuber_coxae'       => ['Lower on left', 'Lower on right'],
		'girth_position'                 => ['Forward', 'Straight'],

		'muscle_wastage'                 => ['Central left', 'Central right', 'Back left', 'Back right', 'Wither', 'Shoulders'],
		'soreness'                       => ['Wither', 'Under waist of saddle', 'Under saddle cantle', 'Behind saddle'],
		'girth_pain'                     => ['Tender behind elbow', 'Deep pectoral muscle', 'Pain on rib pressure', 'Girth gals'],
		'reduced_flexibility'            => ['Up and down', 'To left', 'To right', 'Croup Tuck'],
		'hair_changes'                   => ['White hair', 'Broken hair', 'Curly hair', 'Dry spots'],
		'palation_findings'              => ['Heat', 'Muscle tense', 'Muscle in spasms', 'Rubs & gals'],

		'foot_problems'                  => ['Lameness', 'Infections', 'Damage', 'Pain'],
		'feet_length'                    => ['Short', 'Average', 'Long'],
		'heel_balance'                   => ['High heel', 'Low heel'],
		'foot_balance'                   => ['NF', 'OF', 'NH', 'OH'],
		'shoeing_status'                 => ['Bare foot', 'All 4 feet shod', 'Front feet shod', 'Back feet shod', 'Special/corrective shoeing'],

		'movement_when_saddled'          => ['Tenderness/ discomfort when brushed', 'Dips back when rider mounts', 'Turns head /bites /cow kicks when saddled', 'Tail swishing/ head tossing', 'Cold backed when mounted', 'Bucks/ goes down when saddled', 'When Ridden'],
		'movement_when_saddled_no_rider' => ['Saddle moves excessively', 'Saddle moves symmetrically'],
		'movement_when_ridden'           => ['Hollows back', 'Resistance', 'Bucking', 'Rearing', 'Retricted movement'],

		'saddle_balance'                 => ['Horizontal seat', 'Uphill', 'Downhill'],
		'pommel_clearance'               => ['Mounted', 'Un-Mounted', 'Girthed', 'Not girthed'],
		'saddle_length'                  => ['Short', 'Adequate', 'Long'],
		'tree_match_at_wither'           => ['Parallel to wither', 'Narrow', 'Wide'],
		'tree_match_at_arc_of_spine'     => ['Bridging', 'Adequate', 'Rocking'],
		'channel_depth'                  => ['Shallow', 'Adequate', 'Narrow'],
		'channel_width'                  => ['Wide', 'Adequate', 'Narrow'],
		'contours_of_panel'              => ['Matched to central', 'To outer pitch', 'Not matched'],
		'girth_point_angle'              => ['Straight', 'Slightly forward', 'Forward'],
		'girth_point_position'           => ['Point strap and 1', 'Point strap and 2', 'Point strap and 3', '1 and 2', '1 and 3', '2 and 3'],
		'girth_type'                     => ['Shaped', 'Straight', 'Stud', 'Corrective'],

		'drops_to'                       => ['Neither', 'Left', 'Right'],
		'sits_off_centre'                => ['Neither', 'Left', 'Right'],
	];

	protected $fillable = ['created_at'];

	protected $table = 'fitchecks';

	/**
	 * The Attribute that should be cast to native types.
	 *
	 * @var array
	 */
	protected $casts = [
		'field_data' => 'array',
	];

	public $data = [];

	public function rider()
	{
		return $this->belongsTo('App\Rider');
	}

	public function horse()
	{
		return $this->belongsTo('App\Horse');
	}

	public function saddle()
{
	return $this->belongsTo('App\Saddle');
}

	public function drawingFile()
	{
		return $this->hasMany('App\DrawingFile');
	}

	public function user()
	{
		return $this->belongsTo('App\User');
	}

	public function getBackLengthAttribute()
	{
		return (string) $this->data['back_length'];
	}

	public function setBackLengthAttribute(string $back_length)
	{
		$this->data['back_length'] = $back_length;
	}

	public function getWitherTemplateAttribute()
	{
		return (string) $this->data['wither_template'];
	}

	public function setWitherTemplateAttribute(string $wither_template)
	{
		$this->data['wither_template'] = $wither_template;
	}

	public function getWitherShapeAttribute()
	{
		return (string) $this->data['wither_shape'];
	}

	public function setWitherShapeAttribute(string $wither_shape)
	{
		$this->data['wither_shape'] = $wither_shape;
	}

	public function getWitherBreadthAttribute()
	{
		return (string) $this->data['wither_breadth'];
	}

	public function setWitherBreadthAttribute(string $wither_breadth)
	{
		$this->data['wither_breadth'] = $wither_breadth;
	}

	public function getFlatnessAttribute()
	{
		return (string) $this->data['flatness'];
	}

	public function setFlatnessAttribute(string $flatness)
	{
		$this->data['flatness'] = $flatness;
	}

	public function getBackTypeAttribute()
	{
		return (string) $this->data['back_type'];
	}

	public function setBackTypeAttribute(string $back_type)
	{
		$this->data['back_type'] = $back_type;
	}

	public function getShoulderAttribute()
	{
		return (array) $this->data['shoulder'];
	}

	public function setShoulderAttribute(array $shoulder)
	{
		$this->data['shoulder'] = $shoulder;
	}

	public function getAbdomenAttribute()
	{
		return (string) $this->data['abdomen'];
	}

	public function setAbdomenAttribute(string $abdomen)
	{
		$this->data['abdomen'] = $abdomen;
	}

	public function getFatCoverAttribute()
	{
		return (int) $this->data['fat_cover'];
	}

	public function setFatCoverAttribute(int $fat_cover)
	{
		$this->data['fat_cover'] = $fat_cover;
	}

	public function getMusclingAttribute()
	{
		return (int) $this->data['muscling'];
	}

	public function setMusclingAttribute(int $muscling)
	{
		$this->data['muscling'] = $muscling;
	}

	public function getBackAngleAttribute()
	{
		return (string) $this->data['back_angle'];
	}

	public function setBackAngleAttribute(string $back_angle)
	{
		$this->data['back_angle'] = $back_angle;
	}

	public function getPointOfHipTuberCoxaeAttribute()
	{
		return (string) $this->data['point_of_hip_tuber_coxae'];
	}

	public function setPointOfHipTuberCoxaeAttribute(string $point_of_hip_tuber_coxae)
	{
		$this->data['point_of_hip_tuber_coxae'] = $point_of_hip_tuber_coxae;
	}

	public function getGirthPositionAttribute()
	{
		return (string) $this->data['girth_position'];
	}

	public function setGirthPositionAttribute(string $girth_position)
	{
		$this->data['girth_position'] = $girth_position;
	}

	public function getMuscleWastageAttribute()
	{
		return (array) $this->data['muscle_wastage'];
	}

	public function setMuscleWastageAttribute(array $muscle_wastage)
	{
		$this->data['muscle_wastage'] = $muscle_wastage;
	}

	public function getSorenessAttribute()
	{
		return (array) $this->data['soreness'];
	}

	public function setSorenessAttribute(array $soreness)
	{
		$this->data['soreness'] = $soreness;
	}

	public function getGirthPainAttribute()
	{
		return (array) $this->data['girth_pain'];
	}

	public function setGirthPainAttribute(array $girth_pain)
	{
		$this->data['girth_pain'] = $girth_pain;
	}

	public function getReducedFlexibilityAttribute()
	{
		return (array) $this->data['reduced_flexibility'];
	}

	public function setReducedFlexibilityAttribute(array $reduced_flexibility)
	{
		$this->data['reduced_flexibility'] = $reduced_flexibility;
	}

	public function getHairChangesAttribute()
	{
		return (array) $this->data['hair_changes'];
	}

	public function setHairChangesAttribute(array $hair_changes)
	{
		$this->data['hair_changes'] = $hair_changes;
	}

	public function getPalationFindingsAttribute()
	{
		return (array) $this->data['palation_findings'];
	}

	public function setPalationFindingsAttribute(array $palation_findings)
	{
		$this->data['palation_findings'] = $palation_findings;
	}

	public function getFootProblemsAttribute()
	{
		return (array) $this->data['foot_problems'];
	}

	public function setFootProblemsAttribute(array $foot_problems)
	{
		$this->data['foot_problems'] = $foot_problems;
	}

	public function getFeetLengthAttribute()
	{
		return (string) $this->data['feet_length'];
	}

	public function setFeetLengthAttribute(string $feet_length)
	{
		$this->data['feet_length'] = $feet_length;
	}

	public function getHeelBalanceAttribute()
	{
		return (string) $this->data['heel_balance'];
	}

	public function setHeelBalanceAttribute(string $heel_balance)
	{
		$this->data['heel_balance'] = $heel_balance;
	}

	public function getFootBalanceAttribute()
	{
		return (string) $this->data['foot_balance'];
	}

	public function setFootBalanceAttribute(string $foot_balance)
	{
		$this->data['foot_balance'] = $foot_balance;
	}

	public function getShoeingStatusAttribute()
	{
		return (string) $this->data['shoeing_status'];
	}

	public function setShoeingStatusAttribute(string $shoeing_status)
	{
		$this->data['shoeing_status'] = $shoeing_status;
	}

	public function getMovementWhenSaddledAttribute()
	{
		return (array) $this->data['movement_when_saddled'];
	}

	public function setMovementWhenSaddledAttribute(array $movement_when_saddled)
	{
		$this->data['movement_when_saddled'] = $movement_when_saddled;
	}

	public function getMovementWhenSaddledNoRiderAttribute()
	{
		return (array) $this->data['movement_when_saddled_no_rider'];
	}

	public function setMovementWhenSaddledNoRiderAttribute(array $movement_when_saddled_no_rider)
	{
		$this->data['movement_when_saddled_no_rider'] = $movement_when_saddled_no_rider;
	}

	public function getMovementWhenRiddenAttribute()
	{
		return (array) $this->data['movement_when_ridden'];
	}

	public function setMovementWhenRiddenAttribute(array $movement_when_ridden)
	{
		$this->data['movement_when_ridden'] = $movement_when_ridden;
	}

	public function getSaddleBalanceAttribute()
	{
		return (string) $this->data['saddle_balance'];
	}

	public function setSaddleBalanceAttribute(string $saddle_balance)
	{
		$this->data['saddle_balance'] = $saddle_balance;
	}

	public function getPommelClearanceAttribute()
	{
		return (string) $this->data['pommel_clearance'];
	}

	public function setPommelClearanceAttribute(string $pommel_clearance)
	{
		$this->data['pommel_clearance'] = $pommel_clearance;
	}

	public function getSaddleLengthAttribute()
	{
		return (string) $this->data['saddle_length'];
	}

	public function setSaddleLengthAttribute(string $saddle_length)
	{
		$this->data['saddle_length'] = $saddle_length;
	}

	public function getTreeMatchAtWitherAttribute()
	{
		return (string) $this->data['tree_match_at_wither'];
	}

	public function setTreeMatchAtWitherAttribute(string $tree_match_at_wither)
	{
		$this->data['tree_match_at_wither'] = $tree_match_at_wither;
	}

	public function getTreeMatchAtArcOfSpineAttribute()
	{
		return (string) $this->data['tree_match_at_arc_of_spine'];
	}

	public function setTreeMatchAtArcOfSpineAttribute(string $tree_match_at_arc_of_spine)
	{
		$this->data['tree_match_at_arc_of_spine'] = $tree_match_at_arc_of_spine;
	}

	public function getChannelDepthAttribute()
	{
		return (string) $this->data['channel_depth'];
	}

	public function setChannelDepthAttribute(string $channel_depth)
	{
		$this->data['channel_depth'] = $channel_depth;
	}

	public function getChannelWidthAttribute()
	{
		return (string) $this->data['channel_width'];
	}

	public function setChannelWidthAttribute(string $channel_width)
	{
		$this->data['channel_width'] = $channel_width;
	}

	public function getSaddleTiltAttribute()
	{
		return (bool) $this->data['saddle_tilt'];
	}

	public function setSaddleTiltAttribute(bool $saddle_tilt)
	{
		$this->data['saddle_tilt'] = $saddle_tilt;
	}

	public function getSaddleTwistAttribute()
	{
		return (bool) $this->data['saddle_twist'];
	}

	public function setSaddleTwistAttribute(bool $saddle_twist)
	{
		$this->data['saddle_twist'] = $saddle_twist;
	}

	public function getContoursOfPanelAttribute()
	{
		return (string) $this->data['contours_of_panel'];
	}

	public function setContoursOfPanelAttribute(string $contours_of_panel)
	{
		$this->data['contours_of_panel'] = $contours_of_panel;
	}

	public function getGirthPointAngleAttribute()
	{
		return (string) $this->data['girth_point_angle'];
	}

	public function setGirthPointAngleAttribute(string $girth_point_angle)
	{
		$this->data['girth_point_angle'] = $girth_point_angle;
	}

	public function getGirthPointPositionAttribute()
	{
		return (string) $this->data['girth_point_position'];
	}

	public function setGirthPointPositionAttribute(string $girth_point_position)
	{
		$this->data['girth_point_position'] = $girth_point_position;
	}

	public function getGirthTypeAttribute()
	{
		return (string) $this->data['girth_type'];
	}

	public function setGirthTypeAttribute(string $girth_type)
	{
		$this->data['girth_type'] = $girth_type;
	}

	public function getGirthSizeAttribute()
	{
		return (string) $this->data['girth_size'];
	}

	public function setGirthSizeAttribute(string $girth_size)
	{
		$this->data['girth_size'] = $girth_size;
	}

	public function getDropsToAttribute()
	{
		return (string) $this->data['drops_to'];
	}

	public function setDropsToAttribute(string $drops_to)
	{
		$this->data['drops_to'] = $drops_to;
	}

	public function getSitsOffCentreAttribute()
	{
		return (string) $this->data['sits_off_centre'];
	}

	public function setSitsOffCentreAttribute(string $sits_off_centre)
	{
		$this->data['sits_off_centre'] = $sits_off_centre;
	}

	public function getSitsUprightAttribute()
	{
		return (bool) $this->data['sits_upright'];
	}

	public function setSitsUprightAttribute(bool $sits_upright)
	{
		$this->data['sits_upright'] = $sits_upright;
	}

	public function getFlockingFrontAttribute()
	{
		return (bool) $this->data['flocking_front'];
	}

	public function setFlockingFrontAttribute(bool $flocking_front)
	{
		$this->data['flocking_front'] = $flocking_front;
	}

	public function getFlockingMiddleAttribute()
	{
		return (bool) $this->data['flocking_middle'];
	}

	public function setFlockingMiddleAttribute(bool $flocking_middle)
	{
		$this->data['flocking_middle'] = $flocking_middle;
	}

	public function getFlockingBackAttribute()
	{
		return (bool) $this->data['flocking_back'];
	}

	public function setFlockingBackAttribute(bool $flocking_back)
	{
		$this->data['flocking_back'] = $flocking_back;
	}

	public function getAlterationsAttribute()
	{
		return (array) $this->data['alterations'];
	}

	public function setAlterationsAttribute(array $alterations)
	{
		$this->data['alterations'] = $alterations;
	}

	public function getHistoryOfAlterationsAttribute()
	{
		return (array) $this->data['history_of_alterations'];
	}

	public function setHistoryOfAlterationsAttribute(array $history_of_alterations)
	{
		$this->data['history_of_alterations'] = $history_of_alterations;
	}

	public function getRecommendedProductsAttribute()
	{
		return (array) $this->data['recommended_products'];
	}

	public function setRecommendedProductsAttribute(array $recommended_products)
	{
		$this->data['recommended_products'] = $recommended_products;
	}

}
