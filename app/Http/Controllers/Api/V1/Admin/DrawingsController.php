<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\DrawingFile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Carbon\Carbon;
use App\Saddle;
use Auth;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class DrawingsController extends Controller
{

	public function get($fitcheck_id)
	{
		abort(403);
	}

	public function post(Request $request, $fit_check_id)
	{
		$file = $request->file('image');
		if (!$file) {
			return response()
				->json([
					'success' => false,
				], 200);
		}

		// Use MD5 hash value to improve confidentiality
		$stored_filename = md5($fit_check_id).'.'.$file->getClientOriginalExtension();

		$drawing = DrawingFile::updateOrCreate([
			'fit_check_id' => $fit_check_id,
		],[
			'fit_check_id' => $fit_check_id,
			'filename' => $stored_filename,
			'original_filename' =>  $file->getClientOriginalName(),
			'size' => $file->getSize(),
		]);

		Storage::putFileAs('drawings', $file, $stored_filename);

		return response()
			->json([
				'success' => true,
				'name'      => $stored_filename,
			], 200);
	}

}
