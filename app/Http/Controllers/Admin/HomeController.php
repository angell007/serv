<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Job;
use App\JobApply;
use App\Company;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function index()
    {
        $today = Carbon::now();
        $totalActiveUsers = User::where('is_active', 1)->whereMonth('created_at',  $today->month)->count();
        $totalVerifiedUsers = User::where('verified', 1)->count();
        $totalTodaysUsers = User::where('created_at', 'like', $today->toDateString() . '%')->count();
        $recentUsers = User::orderBy('id', 'DESC')->take(25)->get();
        $totalActiveJobs = Job::where('is_active', 1)->where('expiry_date', '>=', $today)->count();
        $totalFeaturedJobs = Job::where('is_active', '<>', 1)->count();
        $totalTodaysJobs = Job::where('created_at', 'like', $today->toDateString() . '%')->count();
        $recentJobs = Job::orderBy('id', 'DESC')->take(25)->get();
        $OfertaLaboral = JobApply::whereMonth('created_at',  $today->month)->count();
        $totalCompany = Company::whereMonth('created_at',  $today->month)->count();

        $contratado = JobApply::where("status", "=", "contratado")->whereMonth('created_at',  $today->month)->count();

        //aplicaron pero no se contrataron
        $rechazados = Job::join('job_apply', 'job_apply.job_id', '=', 'jobs.id')
            ->where('expiry_date', '<', Carbon::now()->format('Y-m-d'))
            ->where('job_apply.status', '<>', 'contratado')
            ->count();

        //Nadie aplica
        $blank = Job::where('expiry_date', '<', Carbon::now()->format('Y-m-d'))
            ->whereDoesntHave('jobApply', function ($query) {
                $query->whereNotNull('status')
                    ->where('status', '<>', 'contratado');
            })
            ->count();


        //Nadie aplica
        // $blank = Job::whereNotIn('id', function ($query) {
        //     $query->select('job_id')->from('job_apply');
        // })
        //     ->where('expiry_date', '<', Carbon::now()->format('Y-m-d'))
        //     ->count();

        return view('admin.home')
            ->with('totalActiveUsers', $totalActiveUsers)
            ->with('totalVerifiedUsers', $totalVerifiedUsers)
            ->with('totalTodaysUsers', $totalTodaysUsers)
            ->with('recentUsers', $recentUsers)
            ->with('totalActiveJobs', $totalActiveJobs)
            ->with('totalFeaturedJobs', $totalFeaturedJobs)
            ->with('totalTodaysJobs', $totalTodaysJobs)
            ->with('OfertaLaboral', $OfertaLaboral)
            ->with('totalCompany', $totalCompany)
            ->with('contratado', $contratado)
            ->with('recentJobs', $recentJobs)
            ->with('rechazados', $rechazados)
            ->with('blank', $blank);
    }
}
