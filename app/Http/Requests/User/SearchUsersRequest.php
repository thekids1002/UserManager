<?php

namespace App\Http\Requests\User;

use App\Libs\ConfigUtil;
use App\Rules\{CheckGreatherThanDate, CheckLessThanDate, CheckMaxLength};
use DateTime;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class SearchUsersRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array {

        $checkGreaterStart = DateTime::createFromFormat('d/m/Y',
        $this->get('started_date_to')) ? '|before_or_equal:started_date_to' : '';


        return [
            'name' => [
                new CheckMaxLength('User Name', 100),
            ],
            'started_date_from' => 'nullable|date_format:d/m/Y'.$checkGreaterStart,
            'started_date_to' => ['nullable',
                'date_format:d/m/Y',
            ],
        ];
    }

    public function messages() {
        return [
            'started_date_from.date_format' => ConfigUtil::getMessage('EBT008', ['Started Date From']),
            'started_date_to.date_format' => ConfigUtil::getMessage('EBT008', ['Started Date To']),
            'started_date_from.before_or_equal' =>  ConfigUtil::getMessage('EBT044'),
        ];
    }
}
