<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class BaseSalaryRule implements Rule
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
        $valor_sin_signo = preg_replace("/[^0-9]/", "", $value); // Remueve el signo "$"
        $valor_sin_ceros = substr($valor_sin_signo, 0, -2); // Remueve los dos últimos caracteres
        $sb = DB::table('site_settings')->first()->base_salary;
        return !($valor_sin_ceros < $sb);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Rango mínimo: no puede ser inferior al salario mínimo.';
    }
}
