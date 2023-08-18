<?php

namespace App\Exports;

use App\User;

use Illuminate\Contracts\View\View;

use Maatwebsite\Excel\Concerns\FromView;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DiscriminatedExport implements FromView
{
    public function view(): View
    {

        $init = Carbon::parse(request()->get('inicio'))->startOfDay();
        $end =  Carbon::parse(request()->get('fin'))->endOfDay();


        $by_gender = DB::select("SELECT
                                    genders.gender AS genero, COUNT(users.gender_id) AS conteo
                                    FROM
                                    users
                                    LEFT JOIN genders ON users.gender_id = genders.id
                                    WHERE
                                    users.created_at BETWEEN '$init' AND '$end' 
                                    GROUP BY users.gender_id ");

        $by_genders_discriminated = DB::select("SELECT
                                    genders.gender AS genero, COUNT(users.gender_id) AS conteo, marital_status
                                    FROM
                                    users
                                    LEFT JOIN genders ON users.gender_id = genders.id
                                    LEFT JOIN marital_statuses ON users.marital_status_id = marital_statuses.id
                                    WHERE
                                    users.created_at BETWEEN '$init'
                                    AND '$end'
                                    GROUP BY users.gender_id, marital_status");

        $by_candidates = DB::select("SELECT 
                                            genders.gender AS genero, COUNT(users.gender_id) AS cantidad
                                            FROM
                                            job_apply
                                            LEFT JOIN users ON users.id = job_apply.user_id
                                            LEFT JOIN genders ON users.gender_id = genders.id
                                            WHERE
                                            job_apply.updated_at BETWEEN '$init'
                                            AND '$end'
                                            GROUP BY users.gender_id");

        $candidates_by_gender = DB::select("SELECT 
                                        genders.gender AS genero, COUNT(users.gender_id) AS cantidad
                                        FROM
                                        job_apply
                                        LEFT JOIN users ON users.id = job_apply.user_id
                                        LEFT JOIN genders ON users.gender_id = genders.id
                                        WHERE
                                        job_apply.updated_at BETWEEN '$init'
                                        AND '$end'
                                        GROUP BY users.gender_id");

        $contracts = DB::select("SELECT
                                                genders.gender AS genero, COUNT(users.gender_id) AS conteo
                                                FROM
                                                job_apply
                                                LEFT JOIN users ON users.id = job_apply.user_id
                                                LEFT JOIN genders ON users.gender_id = genders.id
                                                WHERE
                                                job_apply.updated_at BETWEEN '$init'
                                                AND '$end'
                                                AND status = 'contratado'
                                                GROUP BY
                                                genders.gender");

        $contracts_by_gender = DB::select("SELECT genders.gender AS genero, COUNT(users.gender_id) AS conteo,  marital_status
                                    FROM
                                    job_apply
                                    LEFT JOIN users ON users.id = job_apply.user_id
                                    LEFT JOIN genders ON users.gender_id = genders.id
                                    LEFT JOIN marital_statuses ON users.marital_status_id = marital_statuses.id
                                    WHERE
                                    job_apply.updated_at BETWEEN '$init'
                                    AND '$end'
                                    AND status = 'contratado'
                                    GROUP BY
                                    genders.gender, marital_status");

        $companies = DB::select("SELECT
                                count(id)
                                FROM
                                companies
                                WHERE
                                companies.created_at BETWEEN '$init'
                                AND '$end'");





        return view('export.customquery', compact('by_gender', 'by_candidates', 'candidates_by_gender', 'contracts', 'contracts_by_gender', 'companies', 'by_genders_discriminated'));
    }
}
