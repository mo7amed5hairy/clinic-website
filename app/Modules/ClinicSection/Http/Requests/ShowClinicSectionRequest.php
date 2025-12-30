<?php

namespace App\Modules\ClinicSection\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShowClinicSectionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id' => ['required', 'exists:clinic_sections,id'],
        ];
    }

    public function attributes(): array
    {
        return [
            'id' => __('modules.clinic_section.messages.id'),
        ];
    }
}
