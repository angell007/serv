<?php

namespace App\Http\Requests;

use App\Rules\Exist;
use App\Rules\isActive;
use Illuminate\Foundation\Http\FormRequest;

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
            // 'email' => 'required'
            'email' => [new Exist, new isActive]
        ];
    }
}
