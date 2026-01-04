<?php

namespace App\Modules\MediaCenter\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMediaCenterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'type'      => 'sometimes|in:image,video',
            'files'     => 'sometimes|array',
        ];
    }

    public function messages(): array
    {
        return [
            'type.in'        => __('media_center.validation.type_in'),
            'files.array'    => __('media_center.validation.files_array'),
        ];
    }
}
