<?php

namespace App\Modules\InsuranceCompany\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInsuranceCompanyRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name'      => ['sometimes', 'required', 'string', 'max:255'],
            'link'      => ['nullable', 'url'],
            'image'     => ['nullable', 'string', 'max:255'],
            'is_active' => ['sometimes', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => __('insurance_company.validation.name_required'),
            'name.max'      => __('insurance_company.validation.name_max'),
            'link.url'      => __('insurance_company.validation.link_url'),
        ];
    }
}
