<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{

	protected $dates = ['date'];
	protected $guarded = [];

	public function client()
	{
		return $this->belongsTo('App\Client');
	}

	public function horse()
	{
		return $this->belongsTo('App\Horse');
	}

	public function rider()
	{
		return $this->belongsTo('App\Rider');
	}

	public function user()
	{
		return $this->belongsTo('App\User');
	}

	public function fitter()
	{
		return $this->belongsTo('App\Fitter');
	}

	public function saddle()
	{
		return $this->belongsTo('App\Saddle');
	}

}
