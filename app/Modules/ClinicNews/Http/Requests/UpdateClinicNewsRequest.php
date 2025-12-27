<?php

namespace App\Modules\ClinicNews\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClinicNewsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // أو طبق سياساتك هنا
    }

    public function rules(): array
    {
        return [
            'title'       => ['sometimes', 'required', 'array'],
            'description' => ['sometimes', 'nullable', 'array'],
            'content'     => ['sometimes', 'nullable', 'array'],
            'image'       => ['sometimes', 'nullable', 'file', 'image', 'max:2048'],
            'is_active'   => ['sometimes', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => __('ClinicNews.validation.title_required'),
            'image.image'    => __('ClinicNews.validation.image_invalid'),
        ];
    }
}
