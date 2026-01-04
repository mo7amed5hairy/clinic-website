<?php

namespace App\Modules\ClinicManagementMember\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClinicManagementMemberRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'      => ['sometimes', 'required', 'string', 'min:2', 'max:255'],
            'position'  => ['sometimes', 'nullable', 'string', 'max:255'],
            'bio'       => ['sometimes', 'nullable', 'string'],
        ];
    }
}
