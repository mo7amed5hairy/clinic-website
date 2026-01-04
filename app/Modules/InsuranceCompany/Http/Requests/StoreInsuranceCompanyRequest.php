<?php

namespace App\Modules\InsuranceCompany\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInsuranceCompanyRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name'      => ['required', 'string', 'max:255'],
            'link'      => ['nullable', 'url'],
            'image'     => ['nullable', 'string', 'max:255'],
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
