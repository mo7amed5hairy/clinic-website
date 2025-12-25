<?php

namespace App\Modules\Clinic\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClinicRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'      => ['sometimes', 'string', 'max:255'],
            'color'     => ['sometimes', 'nullable', 'string', 'max:255'],
            'logo'      => ['sometimes', 'nullable', 'image', 'mimes:png,jpg,jpeg,webp', 'max:2048'],
            'is_active' => ['sometimes', 'boolean'],
        ];
    }
}
