<?php

namespace App\Modules\HeroSection\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreHeroSectionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'    => ['required', 'string', 'max:255'],
            'sub_title'=> ['nullable', 'string', 'max:255'],
            'content'  => ['nullable', 'string'],
            'image'    => ['nullable', 'file', 'mimes:jpeg,png,jpg,gif'],
        ];
    }
}
