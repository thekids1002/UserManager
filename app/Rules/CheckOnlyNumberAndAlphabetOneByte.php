<?php

namespace App\Rules;

use App\Libs\ConfigUtil;
use Illuminate\Contracts\Validation\Rule;

class CheckOnlyNumberAndAlphabetOneByte implements Rule
{
    public function passes($attribute, $value) {
        return preg_match('/^[a-zA-Z0-9]*$/', $value);
    }

    public function message() {
        return  ConfigUtil::getMessage('EBT004',[':attribute']);
    }
}
