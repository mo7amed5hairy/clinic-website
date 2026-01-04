<?php

namespace App\Modules\HeroSection\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateHeroSectionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'    => ['sometimes', 'required', 'string', 'max:255'],
            'sub_title'=> ['sometimes', 'nullable', 'string', 'max:255'],
            'content'  => ['sometimes', 'nullable', 'string'],
            'image'    => ['sometimes', 'nullable', 'file', 'mimes:jpeg,png,jpg,gif'],
        ];
    }
}
