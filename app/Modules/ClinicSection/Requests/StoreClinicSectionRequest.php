<?php

namespace App\Modules\ClinicSection\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClinicSectionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'key' => ['required', 'string'],
            'title' => ['nullable', 'array'],
            'is_active' => ['nullable', 'boolean'],

            'items' => ['nullable', 'array'],
            'items.*.title' => ['nullable', 'array'],
            'items.*.description' => ['nullable', 'array'],
            'items.*.value' => ['nullable', 'string'],
            'items.*.order' => ['nullable', 'integer'],
            'items.*.is_active' => ['nullable', 'boolean'],
        ];
    }

    public function attributes(): array
    {
        return [
            'key' => __('modules.clinic_section.messages.key'),
            'title' => __('modules.clinic_section.messages.title'),
            'items' => __('modules.clinic_section.messages.items'),
            'items.*.title' => __('modules.clinic_section.messages.item.title'),
            'items.*.description' => __('modules.clinic_section.messages.item.description'),
        ];
    }
}
