<?php

namespace App\Http\Requests;

use App\Libs\ConfigUtil;
use App\Rules\CheckExtensionFileCSV;
use Illuminate\Foundation\Http\FormRequest;

class ImportCsvRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array {
        return [
            'file' => [new CheckExtensionFileCSV(),
                        'max:2048',
                    ],
        ];
    }


    public function messages() {
        return [
            'file.max' => ConfigUtil::getMessage('EBT034', ['2MB']),
        ];
    }

    public function attributes() {
        return [
            'file' => 'File',
        ];
    }
}
