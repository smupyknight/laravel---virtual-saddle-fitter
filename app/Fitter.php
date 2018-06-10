<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Fitter extends Model
{

	protected $guarded = [];

	public function clients()
	{
		return $this->belongsToMany('App\Client');
	}

	public function fitchecks()
	{
		return $this->hasManyThrough('App\FitCheck', 'App\User', 'fitter_id', 'user_id', 'id');
	}

	public function horses()
	{
		// return $this->hasManyThrough('App\Horse', 'App\ClientFitter', 'client_id', 'client_id');
		return DB::table('fitters')
				 ->join('client_fitter', 'fitters.id', '=', 'client_fitter.fitter_id')
				 ->join('horses', 'client_fitter.client_id', '=', 'horses.client_id')
				 ->where('fitters.id', $this->id)
				 ->select('horses.*');
	}

	public function riders()
	{
		// return $this->hasManyThrough('App\Rider', 'App\ClientFitter', 'client_id', 'client_id');
		return DB::table('fitters')
				 ->join('client_fitter', 'fitters.id', '=', 'client_fitter.fitter_id')
				 ->join('riders', 'client_fitter.client_id', '=', 'riders.client_id')
				 ->where('fitters.id', $this->id)
				 ->select('riders.*');
	}

	public function saddles()
	{
		// return $this->hasManyThrough('App\Saddle', 'user_id');
		return DB::table('fitters')
				 ->join('client_fitter', 'fitters.id', '=', 'client_fitter.fitter_id')
				 ->join('horses', 'client_fitter.client_id', '=', 'horses.client_id')
				 ->join('saddles', 'horses.id', '=', 'saddles.horse_id')
				 ->where('fitters.id', $this->id)
				 ->select('saddles.*');
	}

	public function bookings()
	{
		// return $this->hasManyThrough('App\Booking', 'App\ClientFitter', 'client_id', 'client_id');
		return DB::table('fitters')
				 ->join('client_fitter', 'fitters.id', '=', 'client_fitter.fitter_id')
				 ->join('bookings', 'client_fitter.client_id', '=', 'bookings.client_id')
				 ->where('fitters.id', $this->id)
				 ->select('bookings.*');
	}

	public function users()
	{
		return $this->hasMany('App\User');
	}

}
