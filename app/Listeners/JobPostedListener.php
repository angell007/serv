<?php

namespace App\Listeners;

use App\Events\JobPosted;
use App\Mail\JobPostedMailable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class JobPostedListener implements ShouldQueue
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


    public function handle(JobPosted $event)
    {
        Mail::send(new JobPostedMailable($event->job));
    }
}
