<?php

namespace App\Rules;

use App\Libs\ConfigUtil;
use Illuminate\Contracts\Validation\Rule;
use Carbon\Carbon;

class CheckLessThanDate implements Rule
{
    private $labelFrom;
    private $labelTo;
    private $valueFrom;
    private $format;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(string $labelFrom, string $labelTo, string $valueFrom, string $format) {
        $this->labelFrom = $labelFrom;
        $this->labelTo = $labelTo;
        $this->valueFrom = $valueFrom;
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
        if (empty($value) && empty($this->valueFrom)) {
            return true;
        }
        try {
            Carbon::createFromFormat($this->format, $value);
            Carbon::createFromFormat($this->format, $this->valueFrom);
        } catch (\Exception $e) {
            return false; // Invalid date format.
        }
        return Carbon::createFromFormat($this->format, $value) >= Carbon::createFromFormat($this->format, $this->valueFrom);
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
