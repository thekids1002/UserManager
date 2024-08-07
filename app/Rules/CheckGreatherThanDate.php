<?php

namespace App\Rules;

use App\Libs\ConfigUtil;
use Illuminate\Contracts\Validation\Rule;
use Carbon\Carbon;

class CheckGreatherThanDate implements Rule
{
    private $labelFrom;
    private $labelTo;
    private $valueTo;
    private $format;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(string $labelFrom, string $labelTo, string $valueTo, string $format) {
        $this->labelFrom = $labelFrom;
        $this->labelTo = $labelTo;
        $this->valueTo = $valueTo;
        $this->format = $format;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value) {
        if (empty($value) && empty($this->valueTo)) {
            return true;
        }
        try {
            Carbon::createFromFormat($this->format, $value);
            Carbon::createFromFormat($this->format, $this->valueTo);
        } catch (\Exception $e) {
            return false; // Invalid date format.
        }
        
        return Carbon::createFromFormat($this->format, $value) <= Carbon::createFromFormat($this->format, $this->valueTo);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message() {
        return ConfigUtil::getMessage('EBT044', [$this->labelTo, $this->labelFrom]);
    }
}
