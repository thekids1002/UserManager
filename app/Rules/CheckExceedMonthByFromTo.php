<?php

namespace App\Rules;

use App\Libs\ConfigUtil;
use Illuminate\Contracts\Validation\Rule;
use Carbon\Carbon;

class CheckExceedMonthByFromTo implements Rule
{
    private $labelFrom;
    private $labelTo;
    private $valueFrom;
    private $valueTo;
    private $exceedMonth;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(string $labelFrom, string $labelTo, string $valueFrom, string $valueTo, int $exceedMonth) {
        $this->labelFrom = $labelFrom;
        $this->labelTo = $labelTo;
        $this->valueFrom = $valueFrom;
        $this->valueTo = $valueTo;
        $this->exceedMonth = $exceedMonth;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value) {
        if (Carbon::hasFormatWithModifiers($this->valueFrom, 'Y#m!') && Carbon::hasFormatWithModifiers($this->valueTo, 'Y#m!')) {
            $monthDiff = Carbon::createFromFormat('Y/m', $this->valueTo)->diffInMonths(Carbon::createFromFormat('Y/m', $this->valueFrom));
            return abs($monthDiff) >= $this->exceedMonth ? false : true;
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message() {
        return ConfigUtil::getMessage('ECL051', [$this->labelFrom, $this->labelTo]);
    }
}
