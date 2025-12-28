<?php

namespace App\Modules\MediaCenter\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMediaCenterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'type'      => 'required|in:image,video',
            'files'     => 'required|array',
            'is_active' => 'nullable|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'type.required'  => __('media_center.validation.type_required'),
            'type.in'        => __('media_center.validation.type_in'),
            'files.required' => __('media_center.validation.files_required'),
            'files.array'    => __('media_center.validation.files_array'),
        ];
    }
}
