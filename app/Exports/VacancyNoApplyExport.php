<?php

namespace App\Exports;

use App\Job;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Carbon\Carbon;

class VacancyNoApplyExport implements FromView
{
    public function view(): View
    {
        $today = Carbon::now();

        $totalTodaysUsers = Job::where('expiry_date', '<', Carbon::now()->format('Y-m-d'))
            ->whereDoesntHave('jobApply', function ($query) {
                $query->whereNotNull('status')
                    ->where('status', '<>', 'contratado');
            })
            ->get();



        return view('export.vacancy', [
            'vacancys' => $totalTodaysUsers
        ]);
    }
}
