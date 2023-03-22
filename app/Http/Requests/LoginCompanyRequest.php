<?php

namespace App\Http\Requests;

use App\Rules\isActive;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class LoginCompanyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'email' => new isActive
        ];
    }


    // public function message()
    // {
    //     return [
    //         'email' => 'Por incumplimiento de las políticas de la Bolsa de Empleo su cuenta fue
    //         suspendida. Para mayor información escríbenos a bolsadeempleo@itc.edu.co'
    //     ];
    // }
}
