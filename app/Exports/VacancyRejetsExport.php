<?php

namespace App\Exports;

use App\Job;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Carbon\Carbon;

class VacancyRejetsExport implements FromView
{
    public function view(): View
    {
        // $today = Carbon::now();

        $totalTodaysUsers =  Job::join('job_apply', 'job_apply.job_id', '=', 'jobs.id')
            ->where('expiry_date', '<', Carbon::now()->format('Y-m-d'))
            ->where('job_apply.status', '<>', 'contratado')
            ->get();

        return view('export.vacancy', [
            'vacancys' => $totalTodaysUsers
        ]);
    }
}
