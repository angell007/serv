<?php

namespace App\Traits;

use ImgUploader;
use App\Company;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

trait CompanyTrait
{


    private function deleteCompanyCamaraComercio($id)
    {
        try {
            $company = Company::findOrFail($id);
            $image = $company->logo;
            if (!empty($image)) {
                File::delete(public_path() . 'uploads/' . $company->camara_comercio);
            }
            return 'ok';
        } catch (ModelNotFoundException $e) {
            return 'notok';
        }
    }
    private function deleteCompanyLogo($id)
    {
        try {
            $company = Company::findOrFail($id);
            $image = $company->logo;
            if (!empty($image)) {
                File::delete(ImgUploader::real_public_path() . 'company_logos/thumb/' . $image);
                File::delete(ImgUploader::real_public_path() . 'company_logos/mid/' . $image);
                File::delete(ImgUploader::real_public_path() . 'company_logos/' . $image);
            }
            return 'ok';
        } catch (ModelNotFoundException $e) {
            return 'notok';
        }
    }

    private function getCompanyIdsAndNumJobs($limit = 16)
    {
        return DB::table('jobs')
            ->select('company_id', DB::raw('COUNT(jobs.company_id) AS num_jobs'))
            ->groupBy('company_id')
            ->orderBy('num_jobs', 'DESC')
            ->limit($limit)
            ->get();
    }

    private function getIndustryIdsFromCompanies($limit = 16)
    {
        $companies = Company::select('industry_id')->active()->whereHas('jobs', function ($query) {
            $query->where('expiry_date', '>', Carbon::now())->active()->notExpire();
        })->withCount(['jobs' => function ($query) {
            $query->active()->notExpire();
        }])->get();

        $industries_array = [];
        foreach ($companies as $company) {
            if (isset($industries_array[$company->industry_id])) {
                $industries_array[$company->industry_id] = $industries_array[$company->industry_id] + $company->jobs_count;
            } else {
                $industries_array[$company->industry_id] = $company->jobs_count;
            }
        }
        arsort($industries_array);
        return array_slice($industries_array, 0, $limit - 1, true);
    }

    private function getCompanySEO($company)
    {
        $title = $company->name;

        $description = 'Company ';
        $keywords = '';

        $description .= ' ' . $company->name;
        $keywords .= $company->name . ',';

        $description .= ' ' . $company->getIndustry('industry');
        $keywords .= $company->getIndustry('industry') . ',';

        $description .= ' ' . $company->getOwnershipType('ownership_type');
        $keywords .= $company->getOwnershipType('ownership_type') . ',';

        $description .= ' ' . $company->location;
        $keywords .= $company->location . ',';

        $description .= ' ' . $company->getCountry('country');
        $keywords .= $company->getCountry('country') . ',';

        $description .= ' ' . $company->getState('state');
        $keywords .= $company->getState('state') . ',';

        $description .= ' ' . $company->getCity('city');
        $keywords .= $company->getCity('city') . ',';

        $seo = (object) array(
            'seo_title' => $title,
            'seo_description' => $description,
            'seo_keywords' => $keywords,
            'seo_other' => ''
        );
        return $seo;
    }
}
