<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

	use HasApiTokens, Notifiable;

	public static $TYPE_USER = 'user';
	public static $TYPE_FITTER_USER = 'fitter-user';
	public static $TYPE_FITTER_ADMIN = 'fitter-admin';
	public static $TYPE_GLOBAL_ADMIN = 'global-admin';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'first_name', 'last_name', 'email', 'password', 'client_id', 'fitter_id', 'type',
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token',
	];

	public function isGlobalAdmin()
	{
		return $this->type == 'global-admin';
	}

	public function isFitterUser()
	{
		return $this->type == 'fitter-user';
	}

	public function isFitterAdmin()
	{
		return $this->type == 'fitter-admin';
	}

	public function isClientUser()
	{
		return ($this->type == 'user') && ($this->client_id);
	}

	public function isFitter()
	{
		return $this->isFitterUser() || $this->isFitterAdmin();
	}

	public function fitter()
	{
		return $this->belongsTo('App\Fitter');
	}

	public function invitation()
	{
		return $this->hasOne('App\Invitation');
	}

	public function client()
	{
		return $this->belongsTo('App\Client');
	}

	public function getDashboardUrl()
	{
		if ($this->isGlobalAdmin()) {
			return '/global-admin/dashboard';
		} elseif ($this->isFitter()) {
			return '/admin/dashboard';
		} else {
			return '/client/dashboard';
		}
	}

	public function createUserFromModel($model, $type) {
		$this->first_name = '';
		$this->last_name = '';
		$this->email = $model->email;
		$this->password = '';
		$this->client_id = $model->id;
		$this->fitter_id = property_exists($model, 'fitter')? $model->fitter->id : null;
		$this->type = $type;
		$this->save();
	}

}