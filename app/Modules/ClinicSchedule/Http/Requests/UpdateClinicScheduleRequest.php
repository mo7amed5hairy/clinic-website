<?php

namespace App\Modules\ClinicSchedule\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClinicScheduleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'date_from' => ['sometimes', 'required', 'date'],
            'date_to'   => ['sometimes', 'required', 'date'],
            'time_from' => ['sometimes', 'required', 'date_format:H:i'],
            'time_to'   => ['sometimes', 'required', 'date_format:H:i'],
        ];
    }
}
