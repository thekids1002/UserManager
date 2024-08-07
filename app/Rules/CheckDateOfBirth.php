<?php

namespace App\Rules;

use App\Libs\ConfigUtil;
use Illuminate\Contracts\Validation\Rule;
use Carbon\Carbon;

class CheckDateOfBirth implements Rule
{
    const AGE = 18;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct() {
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value) {
        if (Carbon::hasFormatWithModifiers($value, 'Y#m#d!')) {
            return Carbon::parse($value)->age >= self::AGE ? true : false;
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message() {
        return ConfigUtil::getMessage('ECL068');
    }
}
