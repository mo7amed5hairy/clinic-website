<?php

namespace App\Modules\Specification\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSpecificationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'        => ['required', 'string', 'min:2', 'max:200'],
            'description' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => __('Specification.validation.name_required'),
            'name.min'      => __('Specification.validation.name_min'),
            'name.max'      => __('Specification.validation.name_max'),
        ];
    }
}
