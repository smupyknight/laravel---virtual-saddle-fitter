<?php

namespace App\Jobs;

use App\Invitation;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendNewClientEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $user;

	/**
	 * Create a new job instance.
	 *
	 * @param User $user
	 */
    public function __construct(User $user)
    {
	    $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
    	$invitation = new Invitation;
    	$invitation->build($this->user->id);
    	$invitation->send();
    }
}