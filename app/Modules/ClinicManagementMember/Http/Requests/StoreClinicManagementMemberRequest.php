<?php

namespace App\Modules\ClinicManagementMember\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClinicManagementMemberRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'      => ['required', 'string', 'min:2', 'max:255'],
            'position'  => ['nullable', 'string', 'max:255'],
            'bio'       => ['nullable', 'string'],
        ];
    }
}
