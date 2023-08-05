<?php

namespace App\Http\Controllers\Company;

use ImgUploader;
use App\User;
use App\Company;
use App\CompanyMessage;
use App\ApplicantMessage;
use App\FavouriteApplicant;
use App\JobApply;
use Carbon\Carbon;
use App\Helpers\DataArrayHelper;
use App\Mail\CompanyContactMail;
use App\Mail\ApplicantContactMail;
use Illuminate\Http\Request;
use App\Http\Requests\Front\CompanyFrontFormRequest;
use App\Http\Controllers\Controller;
use App\Job;
use App\Traits\CompanyTrait;
use App\Traits\Cron;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CompanyController extends Controller
{

    use CompanyTrait;
    use Cron;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('company', ['except' => ['companyDetail', 'sendContactForm']]);
        // $this->runCheckPackageValidity();
    }

    public function index()
    {
        return view('company_home');
    }
    public function company_listing()
    {
        $data['companies'] = Company::paginate(20);
        return view('company.listing')->with($data);
    }

    public function companyProfile()
    {
        $countries = DataArrayHelper::defaultCountriesArray();
        $industries = DataArrayHelper::defaultIndustriesArray();
        $ownershipTypes = DataArrayHelper::defaultOwnershipTypesArray();
        $company = Company::findOrFail(Auth::guard('company')->user()->id);

        $tableName = (new Company())->getTable();
        $columns = DB::getSchemaBuilder()->getColumnListing($tableName);


        $nocountables = ['package_start_date', 'package_end_date', 'remember_token'];

        // Calcular la cantidad total de campos en la tabla
        $totalCampos = count($columns) - 3;

        // Calcular la cantidad de campos llenados en la tabla
        $camposLlenados = 0;
        foreach ($columns as $columna) {
            // Verificar si el valor de la columna no es nulo o está vacío

            if (!in_array($columna, $nocountables)) {
                if (!empty($company->{$columna})) {
                    $camposLlenados++;
                }
            }
        }

        // Calcular el porcentaje de campos llenados
        $percentage = number_format(($camposLlenados / $totalCampos) * 100, 2);

        return view('company.edit_profile')
            ->with('company', $company)
            ->with('countries', $countries)
            ->with('industries', $industries)
            ->with('ownershipTypes', $ownershipTypes)
            ->with('percentage', $percentage);
    }
    public function download($company)
    {

        if (Auth::guard('admin')->user() != null || Auth::guard('company')->user()->id ==  $company) {
            $c = Company::findOrFail($company);
            return response()->download($c->camara_comercio);
        }
        flash('Error, No puedes acceder a este archivo')->error();
        return redirect()->back();
    }

    public function updateCompanyProfile(CompanyFrontFormRequest $request)
    {

        $url = '';
        $company = Company::findOrFail(Auth::guard('company')->user()->id);
        if (request()->hasFile('camara_comercio')) {
            $file = $request->file('camara_comercio');
            $is_deleted = $this->deleteCompanyCamaraComercio($company->id);
            $extension = $file->getClientOriginalExtension();
            $newFileName = 'Camara de comercio_' . $company->id . '.'. $extension; // Genera un nuevo nombre de archivo aleatorio
            $destinationPath = 'uploads';
            $file->move($destinationPath, $newFileName);
            $url = $destinationPath . '/' . $newFileName;
            $company->camara_comercio = $url;
        }

        /*         * **************************************** */
        if ($request->hasFile('logo')) {
            $is_deleted = $this->deleteCompanyLogo($company->id);
            $image = $request->file('logo');
            $fileName = ImgUploader::UploadImage('company_logos', $image, $request->input('name'), 300, 300, false);
            $company->logo = $fileName;
        }
        /*         * ************************************** */
        $company->name = $request->input('name');
        if (!empty($request->input('password'))) {
            $company->password = Hash::make($request->input('password'));
        }
        $company->ceo = $request->input('ceo');
        $company->industry_id = $request->input('industry_id');
        $company->ownership_type_id = $request->input('ownership_type_id');
        $company->description = $request->input('description');
        $company->location = $request->input('location');
        $company->map = $request->input('map');
        $website = $request->input('website');
        $company->website = (false === strpos($website, 'http')) ? 'http://' . $website : $website;
        $company->no_of_employees = $request->input('no_of_employees');
        $company->established_in = $request->input('established_in');
        $company->phone = $request->input('phone');
        $company->linkedin = $request->input('linkedin');
        $company->country_id = $request->input('country_id');
        $company->state_id = $request->input('state_id');
        $company->city_id = $request->input('city_id');
        $company->is_subscribed = $request->input('is_subscribed', 0);
        $company->tipo_identificacion = $request->input('tipo_identificacion');
        $company->identificacion = $request->input('identificacion');
        $company->slug = Str::slug($company->name, '-') . '-' . $company->id;
        $company->update();
        /*************************/
        // Subscription::where('email', 'like', $company->email)->delete();

        // if ((bool)$company->is_subscribed) {
        //     $subscription = new Subscription();
        //     $subscription->email = $company->email;
        //     $subscription->name = $company->name;
        //     $subscription->save();
        //     /*************************/
        //     //	Newsletter::subscribeOrUpdate($subscription->email, ['FNAME'=>$subscription->name]);
        //     /*************************/
        // } else {
        //     /*************************/
        //     //	Newsletter::unsubscribe($company->email);
        //     /*************************/
        // }


        flash(__('Empresa ha sido actualizada'))->success();
        return Redirect::route('company.profile');
    }

    public function addToFavouriteApplicant(Request $request, $application_id, $user_id, $job_id, $company_id)
    {
        $data['user_id'] = $user_id;
        $data['job_id'] = $job_id;
        $data['company_id'] = $company_id;

        $data_save = FavouriteApplicant::create($data);
        flash(__('Job seeker has been added in favorites list'))->success();
        return Redirect::route('applicant.profile', $application_id);
    }

    public function removeFromFavouriteApplicant(Request $request, $application_id, $user_id, $job_id, $company_id)
    {
        $data['user_id'] = $user_id;
        $data['job_id'] = $job_id;
        $data['company_id'] = $company_id;
        FavouriteApplicant::where('user_id', $user_id)
            ->where('job_id', '=', $job_id)
            ->where('company_id', '=', $company_id)
            ->delete();

        flash(__('Job seeker has been removed from favorites list'))->success();
        return Redirect::route('applicant.profile', $application_id);
    }

    public function companyDetail(Request $request, $company_slug)
    {
        $company = Company::where('slug', 'like', $company_slug)->firstOrFail();
        /*         * ************************************************** */
        $seo = $this->getCompanySEO($company);
        /*         * ************************************************** */
        return view('company.detail')
            ->with('company', $company)
            ->with('seo', $seo);
    }

    public function sendContactForm(Request $request)
    {
        $msgresponse = array();
        $rules = array(
            'from_name' => 'required|max:100|between:4,70',
            'from_email' => 'required|email|max:100',
            'subject' => 'required|max:200',
            'message' => 'required',
            'to_id' => 'required',
            'g-recaptcha-response' => 'required|captcha',
        );
        $rules_messages = array(
            'from_name.required' => __('Name is required'),
            'from_email.required' => __('E-mail address is required'),
            'from_email.email' => __('Valid e-mail address is required'),
            'subject.required' => __('Subject is required'),
            'message.required' => __('Message is required'),
            'to_id.required' => __('Recieving Company details missing'),
            'g-recaptcha-response.required' => __('Please verify that you are not a robot'),
            'g-recaptcha-response.captcha' => __('Captcha error! try again'),
        );
        $validation = Validator::make($request->all(), $rules, $rules_messages);
        if ($validation->fails()) {
            $msgresponse = $validation->messages()->toJson();
            echo $msgresponse;
            exit;
        } else {
            $receiver_company = Company::findOrFail($request->input('to_id'));
            $data['company_id'] = $request->input('company_id');
            $data['company_name'] = $request->input('company_name');
            $data['from_id'] = $request->input('from_id');
            $data['to_id'] = $request->input('to_id');
            $data['from_name'] = $request->input('from_name');
            $data['from_email'] = $request->input('from_email');
            $data['from_phone'] = $request->input('from_phone');
            $data['subject'] = $request->input('subject');
            $data['message_txt'] = $request->input('message');
            $data['to_email'] = $receiver_company->email;
            $data['to_name'] = $receiver_company->name;
            $msg_save = CompanyMessage::create($data);
            $when = Carbon::now()->addMinutes(5);
            Mail::send(new CompanyContactMail($data));
            $msgresponse = ['success' => 'success', 'message' => __('Message sent successfully')];
            echo json_encode($msgresponse);
            exit;
        }
    }

    public function sendApplicantContactForm(Request $request)
    {
        $msgresponse = array();
        $rules = array(
            'from_name' => 'required|max:100|between:4,70',
            'from_email' => 'required|email|max:100',
            'subject' => 'required|max:200',
            'message' => 'required',
            'to_id' => 'required',
        );
        $rules_messages = array(
            'from_name.required' => __('Name is required'),
            'from_email.required' => __('E-mail address is required'),
            'from_email.email' => __('Valid e-mail address is required'),
            'subject.required' => __('Subject is required'),
            'message.required' => __('Message is required'),
            'to_id.required' => __('Recieving applicant details missing'),
            'g-recaptcha-response.required' => __('Please verify that you are not a robot'),
            'g-recaptcha-response.captcha' => __('Captcha error! try again'),
        );
        $validation = Validator::make($request->all(), $rules, $rules_messages);
        if ($validation->fails()) {
            $msgresponse = $validation->messages()->toJson();
            echo $msgresponse;
            exit;
        } else {
            $receiver_user = User::findOrFail($request->input('to_id'));
            $data['user_id'] = $request->input('user_id');
            $data['user_name'] = $request->input('user_name');
            $data['from_id'] = $request->input('from_id');
            $data['to_id'] = $request->input('to_id');
            $data['from_name'] = $request->input('from_name');
            $data['from_email'] = $request->input('from_email');
            $data['from_phone'] = $request->input('from_phone');
            $data['subject'] = $request->input('subject');
            $data['message_txt'] = $request->input('message');
            $data['to_email'] = $receiver_user->email;
            $data['to_name'] = $receiver_user->getName();
            $msg_save = ApplicantMessage::create($data);
            $when = Carbon::now()->addMinutes(5);
            Mail::send(new ApplicantContactMail($data));
            $msgresponse = ['success' => 'success', 'message' => __('Message sent successfully')];
            echo json_encode($msgresponse);
            exit;
        }
    }

    public function postedJobs(Request $request)
    {
        $jobs = Auth::guard('company')->user()->jobs()->paginate(10);
        return view('job.company_posted_jobs')
            ->with('jobs', $jobs);
    }

    public function listAppliedUsers(Request $request, $job_id)
    {
        $job_applications = JobApply::where('job_id', '=', $job_id)->get();

        return view('job.job_applications')
            ->with('job_applications', $job_applications);
    }

    public function listFavouriteAppliedUsers(Request $request, $job_id)
    {
        $company_id = Auth::guard('company')->user()->id;
        $user_ids = FavouriteApplicant::where('job_id', '=', $job_id)->where('company_id', '=', $company_id)->pluck('user_id')->toArray();
        $job_applications = JobApply::where('job_id', '=', $job_id)->whereIn('user_id', $user_ids)->get();

        return view('job.job_applications')
            ->with('job_applications', $job_applications);
    }

    public function applicantProfile($application_id)
    {

        $job_application = JobApply::findOrFail($application_id);
        $user = $job_application->getUser();
        $job = $job_application->getJob();
        $company = $job->getCompany();
        $profileCv = $job_application->getProfileCv();

        /*         * ********************************************** */
        $num_profile_views = $user->num_profile_views + 1;
        $user->num_profile_views = $num_profile_views;
        $user->update();
        /*         * ********************************************** */
        return view('user.applicant_profile')
            ->with('job_application', $job_application)
            ->with('user', $user)
            ->with('job', $job)
            ->with('company', $company)
            ->with('profileCv', $profileCv)
            ->with('page_title', 'Applicant Profile')
            ->with('form_title', 'Contact Applicant');
    }

    public function userProfile($id)
    {

        $user = User::findOrFail($id);
        $profileCv = $user->getDefaultCv();

        /*         * ********************************************** */
        $num_profile_views = $user->num_profile_views + 1;
        $user->num_profile_views = $num_profile_views;
        $user->update();
        /*         * ********************************************** */
        return view('user.applicant_profile')
            ->with('user', $user)
            ->with('profileCv', $profileCv)
            ->with('page_title', 'Job Seeker Profile')
            ->with('form_title', 'Contact Job Seeker');
    }

    public function companyFollowers()
    {
        $company = Company::findOrFail(Auth::guard('company')->user()->id);
        $userIdsArray = $company->getFollowerIdsArray();
        $users = User::whereIn('id', $userIdsArray)->get();

        return view('company.follower_users')
            ->with('users', $users)
            ->with('company', $company);
    }
    public function companyVacancyExpiry()
    {
        //aplicaron pero no se contrataron
        $auxjobs = Job::join('job_apply', 'job_apply.job_id', 'jobs.id')
            ->where('expiry_date', '<', Carbon::now()->format('Y-m-d'))
            ->where('job_apply.status', '<>', 'contratado')
            ->where('jobs.company_id', Auth::guard('company')->user()->id)
            ->where('jobs.close', 0)
            ->get();

        $jobs = Job::whereIn('id', $auxjobs->pluck('job_id')->unique())->get();

        //Nadie aplica
        $blank = Job::whereNotIn('id', function ($query) {
            $query->select('job_id')->from('job_apply');
        })
            ->where('jobs.company_id', Auth::guard('company')->user()->id)
            ->where('expiry_date', '<', Carbon::now()->format('Y-m-d'))
            ->get();

        return view('company.vacancy_expiry', compact('jobs', 'blank'));
    }
    public function CloseProcess()
    {
        $job =  Job::findOrFail(request()->get('job'));
        $job->reazon = request()->get('mensaje');
        $job->close = 1;
        $job->save();
        return back();
    }

    public function companyMessages()
    {
        $company = Company::findOrFail(Auth::guard('company')->user()->id);
        $messages = CompanyMessage::where('company_id', '=', $company->id)
            ->orderBy('is_read', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('company.company_messages')
            ->with('company', $company)
            ->with('messages', $messages);
    }

    public function companyMessageDetail($message_id)
    {
        $company = Company::findOrFail(Auth::guard('company')->user()->id);
        $message = CompanyMessage::findOrFail($message_id);
        $message->update(['is_read' => 1]);

        return view('company.company_message_detail')
            ->with('company', $company)
            ->with('message', $message);
    }
}
