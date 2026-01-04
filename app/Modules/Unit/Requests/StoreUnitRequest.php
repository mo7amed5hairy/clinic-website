<?php

namespace App\Modules\Unit\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUnitRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'image'       => 'nullable|image',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
