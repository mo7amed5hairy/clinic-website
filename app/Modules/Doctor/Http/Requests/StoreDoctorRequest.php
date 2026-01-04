<?php

namespace App\Modules\Doctor\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDoctorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'doctor_data' => ['required', 'array'],
            'doctor_data.name' => ['required', 'array'],
            'doctor_data.name.ar' => ['required', 'string'],
            'doctor_data.name.en' => ['required', 'string'],
        ];
    }
}
