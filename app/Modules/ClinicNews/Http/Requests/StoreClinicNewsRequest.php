<?php

namespace App\Modules\ClinicNews\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClinicNewsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // أو طبق سياساتك هنا
    }

    public function rules(): array
    {
        return [
            'title'       => ['required', 'array'],
            'description' => ['nullable', 'array'],
            'content'     => ['nullable', 'array'],
            'image'       => ['nullable', 'file', 'image', 'max:2048'],
            'is_active'   => ['nullable', 'boolean'],
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
