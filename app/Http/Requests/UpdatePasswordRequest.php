<?php

namespace App\Http\Requests;

use App\Libs\ConfigUtil;
use App\Rules\CheckMaxLength;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'password' => $this->isPasswordUpdateRequested() ? [
                'required',
                'between:8,20',
                'regex:/^(?=.*[0-9])(?=.*[a-zA-Z])[0-9a-zA-z]+$/',
                new CheckMaxLength('Password', 20),
            ] : '',
            'repassword' => $this->isPasswordUpdateRequested() ? [
                'required',
                'same:password',
                new CheckMaxLength('Password Confirmation', 20),
            ] : '',
        ];
    }


    public function messages() {
        return [
            'password.required' => ConfigUtil::getMessage('EBT001', [':attribute']),
            'password.regex' => ConfigUtil::getMessage('EBT025', [':attribute']),
            'password.between' => ConfigUtil::getMessage('EBT023'),

            'repassword.required' => ConfigUtil::getMessage('EBT001', [':attribute']),
            'repassword.same' => ConfigUtil::getMessage('EBT030'),
        ];
    }

    public function attributes() {
        return [
            'name' => 'User Name',
            'email' => 'Email',
            'group_id' => 'Group',
            'started_date' => 'Started Date',
            'position_id' => 'Position',
            'password' => 'Password',
            'repassword' => 'Password Confirmation',
        ];
    }

    private function isPasswordUpdateRequested(): bool {
        return $this->filled('password');
    }
}
