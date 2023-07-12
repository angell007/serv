<?php

namespace App\Console\Commands;

use App\Company;
use App\Job;
use App\Mail\AlertJobsMail;
use App\Mail\ExpiryVacancyMail;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class SendEmailCommand extends Command
{
    /**
     * Execute the console command.
     *
     * @return int
     */
    protected $signature = 'email:send';
    protected $description = 'Send email to senior entrepreneur';

    public function handle()
    {
        try {
            $subject = 'Ofertas laborales expiradas';
            $message = 'Señor empresario, usted tiene ofertas laborales cuya fecha de expiración ha pasado y debe cerrarlas.';

            $companies = Company::get(['email', 'id']);

            foreach ($companies as $company) {

                if ($this->companyVacancyExpiry($company->id)) {
                    $data = ['subject' => $subject, 'email' => $company->email, 'jobs' => [], 'message_c' => $message];
                    Mail::send(new ExpiryVacancyMail($data));
                    $this->info('Email sent successfully!');
                }
            }
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }

    public function companyVacancyExpiry($id)
    {
        //aplicaron pero no se contrataron
        $auxjobs = Job::join('job_apply', 'job_apply.job_id', 'jobs.id')
            ->where('expiry_date', '<', Carbon::now()->format('Y-m-d'))
            ->where('job_apply.status', '<>', 'contratado')
            ->where('jobs.company_id', $id)
            ->where('jobs.close', 0)
            ->get();

        $jobs = Job::whereIn('id', $auxjobs->pluck('job_id')->unique())->count();

        if ($jobs > 1) return true;


        //Nadie aplica
        $blank = Job::whereNotIn('id', function ($query) {
            $query->select('job_id')->from('job_apply');
        })
            ->where('jobs.company_id', $id)
            ->where('expiry_date', '<', Carbon::now()->format('Y-m-d'))
            ->count();

        if ($blank > 1) return true;

        return false;
    }
}
