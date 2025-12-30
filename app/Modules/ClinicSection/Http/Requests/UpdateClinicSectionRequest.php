<?php

namespace App\Modules\ClinicSection\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClinicSectionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id' => ['required', 'exists:clinic_sections,id'],
            'key' => ['sometimes', 'string'],
            'title' => ['nullable', 'array'],
            'is_active' => ['sometimes', 'boolean'],

            'items' => ['nullable', 'array'],
            'items.*.id' => ['sometimes', 'exists:clinic_section_items,id'],
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
            'id' => __('modules.clinic_section.messages.id'),
            'key' => __('modules.clinic_section.messages.key'),
            'title' => __('modules.clinic_section.messages.title'),
            'items' => __('modules.clinic_section.messages.items'),
            'items.*.id' => __('modules.clinic_section.messages.item.id'),
            'items.*.title' => __('modules.clinic_section.messages.item.title'),
            'items.*.description' => __('modules.clinic_section.messages.item.description'),
            'items.*.value' => __('modules.clinic_section.messages.item.value'),
            'items.*.order' => __('modules.clinic_section.messages.item.order'),
            'items.*.is_active' => __('modules.clinic_section.messages.item.is_active'),
        ];
    }
}
