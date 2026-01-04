<?php

namespace App\Modules\Unit\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUnitRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name'        => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'image'       => 'nullable|image',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
