<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Saddle extends Model
{

	protected $guarded = [];

	protected $dates = ['purchased_at'];
	protected $appends = ['available_types', 'available_panel_types', 'available_seat_styles', 'available_gullet_sizes'];

	public function horse()
	{
		return $this->belongsTo('App\Horse', 'horse_id');
	}

	public function brand()
	{
		return $this->belongsTo('App\Brand', 'brand_id');
	}

	public function style()
	{
		return $this->belongsTo('App\Style', 'style_id');
	}

	public function rider()
	{
		return $this->belongsTo('App\Rider');
	}

	public function fitchecks()
	{
		return $this->hasMany('App\FitCheck');
	}

	public function getAvailableTypesAttribute()
	{
		return $this->getFieldOptions('type');
	}

	public function getAvailablePanelTypesAttribute()
	{
		return $this->getFieldOptions('panel_type');
	}

	public function getAvailableSeatStylesAttribute()
	{
		return $this->getFieldOptions('seat_style');
	}

	public function getAvailableGulletSizesAttribute()
	{
		return $this->getFieldOptions('gullet_size');
	}

	public function getFieldOptions($field_name)
	{
		$type = DB::select(DB::raw('SHOW COLUMNS FROM '.$this->getTable().' WHERE Field = "'.$field_name.'"'))[0]->Type;
	    preg_match("/^enum\(\'(.*)\'\)$/", $type, $matches);
	    $enum = explode("','", $matches[1]);
	    return $enum;
	}

}