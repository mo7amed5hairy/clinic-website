<?php

namespace App\Modules\ClinicStatistic\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClinicStatisticRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', \App\Modules\ClinicStatistic\Models\ClinicStatistic::class);
    }

    public function rules(): array
    {
        return [
            'statistics_name' => ['required', 'string', 'max:255'],
            'statistic_value' => ['required', 'string', 'max:255'],
            'is_active'       => ['nullable', 'boolean'],
        ];
    }
}
