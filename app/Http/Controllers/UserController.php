<?php

namespace App\Http\Controllers;

use App\Helpers\ImageUploadingHelper;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\UploadedFile;
use App\User;
use App\Subscription;
use App\ApplicantMessage;
use App\Company;
use App\FavouriteCompany;
use App\Alert;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\CommonUserFunctions;
use App\Traits\ProfileSummaryTrait;
use App\Traits\ProfileCvsTrait;
use App\Traits\ProfileProjectsTrait;
use App\Traits\ProfileExperienceTrait;
use App\Traits\ProfileEducationTrait;
use App\Traits\ProfileSkillTrait;
use App\Traits\ProfileLanguageTrait;
use App\Traits\Skills;
use App\Http\Requests\Front\UserFrontFormRequest;
use App\Helpers\DataArrayHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{

    use CommonUserFunctions;
    use ProfileSummaryTrait;
    use ProfileCvsTrait;
    use ProfileProjectsTrait;
    use ProfileExperienceTrait;
    use ProfileEducationTrait;
    use ProfileSkillTrait;
    use ProfileLanguageTrait;
    use Skills;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth', ['only' => ['myProfile', 'updateMyProfile', 'viewPublicProfile']]);
        $this->middleware('auth', ['except' => ['uploadParticipant', 'showApplicantProfileEducation', 'changePass', 'showApplicantProfileProjects', 'showApplicantProfileExperience', 'showApplicantProfileSkills', 'showApplicantProfileLanguages']]);
    }

    public function viewPublicProfile($id)
    {

        $user = User::findOrFail($id);
        $profileCv = $user->getDefaultCv();

        return view('user.applicant_profile')
            ->with('user', $user)
            ->with('profileCv', $profileCv)
            ->with('page_title', $user->getName())
            ->with('form_title', 'Contact ' . $user->getName());
    }

    public function myProfile()
    {
        $genders = DataArrayHelper::langGendersArray();
        $maritalStatuses = DataArrayHelper::langMaritalStatusesArray();
        $nationalities = DataArrayHelper::langNationalitiesArray();
        $countries = DataArrayHelper::langCountriesArray();
        $jobExperiences = DataArrayHelper::langJobExperiencesArray();
        $careerLevels = DataArrayHelper::langCareerLevelsArray();
        $industries = DataArrayHelper::langIndustriesArray();
        $functionalAreas = DataArrayHelper::langFunctionalAreasArray();

        $upload_max_filesize = UploadedFile::getMaxFilesize() / (1048576);

        $user = User::findOrFail(Auth::user()->id);
        $tableName = (new User())->getTable();
        $columns = DB::getSchemaBuilder()->getColumnListing($tableName);


        $nocountables = ['package_start_date', 'package_end_date', 'remember_token', 'first_lastname', 
        'second_lastname' , 'provider', 'provider_id', 'verification_token' , 'jobs_quota',
         'availed_jobs_quota', 'email_verified_at', 'lang', 'academic_training_completion_date', 'email_verified_at'];

        // Calcular la cantidad total de campos en la tabla
        $totalCampos = count($columns) - 14;

        // Calcular la cantidad de campos llenados en la tabla
        $camposLlenados = 0;
        foreach ($columns as $columna) {
            // Verificar si el valor de la columna no es nulo o está vacío

            if (!in_array($columna, $nocountables)) {
                if (!empty($user->{$columna})) {
                    $camposLlenados++;
                }
            }
        }

        // Calcular el porcentaje de campos llenados
        $percentage = number_format(($camposLlenados / $totalCampos) * 100, 2);

        return view('user.edit_profile')
            ->with('genders', $genders)
            ->with('maritalStatuses', $maritalStatuses)
            ->with('nationalities', $nationalities)
            ->with('countries', $countries)
            ->with('jobExperiences', $jobExperiences)
            ->with('careerLevels', $careerLevels)
            ->with('industries', $industries)
            ->with('functionalAreas', $functionalAreas)
            ->with('user', $user)
            ->with('upload_max_filesize', $upload_max_filesize)
            ->with('percentage', $percentage);
    }

    public function updateMyProfile(UserFrontFormRequest $request)
    {
        $user = User::findOrFail(Auth::user()->id);
        /*         * **************************************** */
        if ($request->hasFile('image')) {
            $is_deleted = $this->deleteUserImage($user->id);
            $image = $request->file('image');
            $fileName = ImageUploadingHelper::UploadImage('user_images', $image, $request->input('name'), 300, 300, false);
            $user->image = $fileName;
        }
        /*         * ************************************** */
        $user->first_name = $request->input('first_name');
        $user->middle_name = $request->input('middle_name');
        $user->last_name = $request->input('last_name');
        /*         * *********************** */
        $user->name = $user->getName();
        /*         * *********************** */
        $user->email = $request->input('email');
        if (!empty($request->input('password'))) {
            $user->password = Hash::make($request->input('password'));
        }
        $user->father_name = $request->input('father_name');
        $user->date_of_birth = $request->input('date_of_birth');
        $user->gender_id = $request->input('gender_id');
        $user->marital_status_id = $request->input('marital_status_id');
        $user->nationality_id = $request->input('nationality_id');
        $user->national_id_card_number = $request->input('national_id_card_number');
        $user->country_id = $request->input('country_id');
        $user->state_id = $request->input('state_id');
        $user->city_id = $request->input('city_id');
        $user->phone = $request->input('phone');
        $user->mobile_num = $request->input('mobile_num');
        $user->job_experience_id = $request->input('job_experience_id');
        $user->career_level_id = $request->input('career_level_id');
        $user->industry_id = $request->input('industry_id');
        $user->functional_area_id = $request->input('functional_area_id');
        $user->current_salary = $request->input('current_salary');
        $user->expected_salary = $request->input('expected_salary');
        $user->salary_currency = $request->input('salary_currency');
        $user->street_address = $request->input('street_address');
        $user->is_subscribed = $request->input('is_subscribed', 0);
        $user->borncountry_id = $request->input('borncountry_id');
        $user->bornstate_id = $request->input('bornstate_id');
        $user->borncity_id = $request->input('borncity_id');
        
        $user->doc_type = $request->input('doc_type');

        $user->update();

        $this->updateUserFullTextSearch($user);
        /*************************/
        Subscription::where('email', 'like', $user->email)->delete();

        if ((bool)$user->is_subscribed) {
            $subscription = new Subscription();
            $subscription->email = $user->email;
            $subscription->name = $user->name;
            $subscription->save();

            /*************************/
            // 			Newsletter::subscribeOrUpdate($subscription->email, ['FNAME'=>$subscription->name]);
            /*************************/
        } else {
            /*************************/
            // 			Newsletter::unsubscribe($user->email);
            /*************************/
        }

        flash(__('You have updated your profile successfully'))->success();
        return Redirect::route('my.profile');
    }

    public function addToFavouriteCompany(Request $request, $company_slug)
    {
        $data['company_slug'] = $company_slug;
        $data['user_id'] = Auth::user()->id;
        $data_save = FavouriteCompany::create($data);
        flash(__('Company has been added in favorites list'))->success();
        return Redirect::route('company.detail', $company_slug);
    }

    public function removeFromFavouriteCompany(Request $request, $company_slug)
    {
        $user_id = Auth::user()->id;
        FavouriteCompany::where('company_slug', 'like', $company_slug)->where('user_id', $user_id)->delete();

        flash(__('Company has been removed from favorites list'))->success();
        return Redirect::route('company.detail', $company_slug);
    }

    public function myFollowings()
    {
        $user = User::findOrFail(Auth::user()->id);
        $companiesSlugArray = $user->getFollowingCompaniesSlugArray();
        $companies = Company::whereIn('slug', $companiesSlugArray)->get();

        return view('user.following_companies')
            ->with('user', $user)
            ->with('companies', $companies);
    }

    public function myMessages()
    {
        $user = User::findOrFail(Auth::user()->id);
        $messages = ApplicantMessage::where('user_id', '=', $user->id)
            ->orderBy('is_read', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.applicant_messages')
            ->with('user', $user)
            ->with('messages', $messages);
    }

    public function applicantMessageDetail($message_id)
    {
        $user = User::findOrFail(Auth::user()->id);
        $message = ApplicantMessage::findOrFail($message_id);
        $message->update(['is_read' => 1]);

        return view('user.applicant_message_detail')
            ->with('user', $user)
            ->with('message', $message);
    }

    public function myAlerts()
    {
        $alerts = Alert::where('email', Auth::user()->email)
            ->orderBy('created_at', 'desc')
            ->get();
        //dd($alerts);
        return view('user.applicant_alerts')
            ->with('alerts', $alerts);
    }
    public function delete_alert($id)
    {
        $alert = Alert::findOrFail($id);
        $alert->delete();
        $arr = array('msg' => 'A Alert has been successfully deleted. ', 'status' => true);
        return Response()->json($arr);
    }

    public function changePass()
    {
        $user = User::find(request()->get('id'));

        if (Hash::check(request()->get('pass'), $user->password)) {

            $user->password = Hash::make(request()->get('repass'));
            $user->save();
            $arr = array('msg' => 'Contraseña actualizada correctamente ', 'status' => true);
            return Response()->json($arr);
        }

        $arr = array('msg' => 'La contraseña no coincide con tu contraseña actual ', 'status' => true);
        return Response()->json($arr, 400);
    }



    public function  uploadParticipant()
    {
        DB::table('participants')->insertGetId(request()->get('data'));
        return Response()->json(request()->all(), 200);
    }
}
