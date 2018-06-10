<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DrawingFile extends Model
{
	protected $fillable = ['fit_check_id', 'filename', 'original_filename', 'size'];

	public function fitcheck()
	{
		return $this->belongsTo('App\FitCheck');
	}

}
