<?php

namespace App\Listeners;

use App\Events\JobApplied;
use App\Mail\JobAppliedCompanyMailable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class JobAppliedCompanyListener implements ShouldQueue
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
        Mail::send(new JobAppliedCompanyMailable($event->job, $event->jobApply));
    }

}
