<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Horse extends Model
{

	const COLOURS = [
		'bay',
		'dark bay',
		'blood bay',
		'brown bay',
		'Chestnut',
		'liver chestnut',
		'sorrel chestnut',
		'blond or light chestnut',
		'Grey',
		'steel grey',
		'dapple grey',
		'fleabitten grey',
		'rose grey',
		'black',
		'brindle',
		'buckskin',
		'champagne',
		'cream dilution',
		'cremello',
		'dun',
		'blue dun (grullo, grulla)',
		'red dun',
		'bay dun',
		'buckskin dun',
		'leopard',
		'palomino',
		'pinto',
		'piepald',
		'skewbald',
		'overo',
		'sabino',
		'tobiano',
		'tovero',
		'rabicano',
		'roan',
		'red roan',
		'bay roan',
		'blue roan',
		'dapple',
		'black',
		'cream',
		'whiteblood bay',
		'brown bay',
		'chestnut',
		'liver chestnut',
		'sorrel chestnut',
		'blond or light chestnut',
		'Grey',
		'steel grey',
		'dapple grey',
		'fleabitten grey',
		'rose grey',
		'black',
		'brindle',
		'buckskin',
		'champagne',
		'cream dilution',
		'cremello',
		'dun',
		'blue dun (grullo, grulla)',
		'red dun',
		'bay dun',
		'buckskin dun',
		'leopard',
		'palomino',
		'pinto',
		'piepald',
		'skewbald',
		'overo',
		'sabino',
		'tobiano',
		'tovero',
		'rabicano',
		'roan',
		'red roan',
		'bay roan',
		'blue roan',
		'dapple',
		'black',
		'cream',
		'white',
	];

	protected $fillable = ['stable_name'];

	protected $dates = ['dob'];

	public function riders()
	{
		return $this->hasMany('App\Rider', 'client_id');
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

	public function client()
	{
		return $this->belongsTo('App\Client');
	}

	public function fitters()
	{
		return $this->belongsToMany('App\Fitter', 'client_fitter', 'client_id');
	}

	public function breed()
	{
		return $this->hasOne('App\Breed', 'breed');
	}

}
