<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{

	protected $fillable = ['name'];

	public function fitters()
	{
		return $this->belongsToMany('App\Fitter');
	}

	public function horses()
	{
		return $this->hasMany('App\Horse');
	}

	public function riders()
	{
		return $this->hasMany('App\Rider');
	}

	public function saddles()
	{
		return $this->hasManyThrough('App\Saddle', 'App\Horse', 'client_id', 'horse_id', 'id');
	}

	public function users()
	{
		return $this->hasMany('App\User');
	}

	public function bookings()
	{
		return $this->hasMany('App\Booking');
	}

}
