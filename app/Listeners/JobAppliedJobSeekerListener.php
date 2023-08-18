<?php

namespace App\Listeners;

use App\Events\JobApplied;
use App\Mail\JobAppliedJobSeekerMailable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class JobAppliedJobSeekerListener implements ShouldQueue
{

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }


    public function handle(JobApplied $event)
    {
        Mail::send(new JobAppliedJobSeekerMailable($event->job, $event->jobApply));
    }

}
