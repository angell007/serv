<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class isActive implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $companie = DB::table('companies')->where('email', $value)->first();
        if (!isset($companie)) return false;
        return  boolval($companie->is_active);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Por incumplimiento de las políticas de la Bolsa de Empleo su cuenta fue
        suspendida. Para mayor información escríbenos a bolsadeempleo@itc.edu.co';
    }
}
