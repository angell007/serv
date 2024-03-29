<?php



namespace App\Exports;



use App\Job;

use Illuminate\Contracts\View\View;

use Maatwebsite\Excel\Concerns\FromView;

use Carbon\Carbon;



class VacancyInactiveExport implements FromView

{

    public function view(): View

    {

        $today = Carbon::now();





        $totalTodaysUsers =  Job::join('companies', 'companies.id', 'jobs.company_id')

            ->where('jobs.is_active', 0)->get();





        return view('export.vacancy', [

            'vacancys' => $totalTodaysUsers

        ]);
    }
}
