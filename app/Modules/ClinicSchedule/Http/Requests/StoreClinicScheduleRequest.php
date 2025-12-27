<?php

namespace App\Modules\ClinicSchedule\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClinicScheduleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'date_from' => ['required', 'date'],
            'date_to'   => ['required', 'date'],
            'time_from' => ['required', 'date_format:H:i'],
            'time_to'   => ['required', 'date_format:H:i'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }
}
