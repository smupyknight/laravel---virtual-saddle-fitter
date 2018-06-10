<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Mail;

class Invitation extends Model
{

	protected $guarded = [];

	public function send()
	{
		$data = [
			'invitation' => $this,
		];

		try {
			Mail::send('emails.invitations-email', $data, function ($mail) {
				$mail->from('noreply@virtualsaddlefitter.com');
				$mail->to($this->user->email);
				$mail->subject('Invitation to join VirtualSaddleFitter');
			});
		} catch (Exception $e) {
			Log::info('Sending invite email error : '.$e->getMessage());
		}
	}

	public function user()
	{
		return $this->belongsTo('App\User');
	}

	/**
	 * Create a new invitation token and link the invitation to a user.
	 * @param $user_id
	 * @return null|string
	 */
	public function build($user_id) {
		$token = null;
		do {
			$token = str_random(10);
		} while (self::where('token', $token)->first());

		$this->token = $token;
		$this->user_id = $user_id;
		$this->save();

		return $token;
	}

}