<?php
/**
 * Created by PhpStorm.
 * User: tony
 * Date: 24/1/18
 * Time: 4:42 PM
 */

namespace App\Http\Controllers;


use App\DrawingFile;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;

class DrawingsController
{
	public function show($id){
		$drawing = DrawingFile::findOrFail($id);

		return new BinaryFileResponse(storage_path().'/app/drawings/'.$drawing->filename);
	}
}