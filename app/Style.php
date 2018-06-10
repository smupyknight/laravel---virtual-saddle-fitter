<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Style extends Model
{

	public function brand()
	{
		return $this->belongsTo('App\Brand', 'brand_id');
	}

	public function type()
	{
		return $this->belongsTo('App\Type', 'type_id');
	}

}
