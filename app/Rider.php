<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rider extends Model
{

	protected $fillable = ['mobile'];

	public function horses()
	{
		return $this->hasMany('App\Horse', 'client_id', 'client_id');
	}

	public function client()
	{
		return $this->belongsTo('App\Client');
	}

	public function saddles()
	{
		return $this->hasMany('App\Saddle');
	}

	public function bookings()
	{
		return $this->hasMany('App\Booking');
	}

	public function fitchecks()
	{
		return $this->hasMany('App\FitCheck');
	}

	public function getFullName()
	{
		return $this->first_name . ' ' . $this->last_name;
	}

	public function getVipMemberStatus()
	{
		return ($this->is_vip_member ? 'Yes' : 'No');
	}

	public function getRegisteredStatus()
	{
		return ($this->has_registered_on_website ? 'Yes' : 'No');
	}

}
