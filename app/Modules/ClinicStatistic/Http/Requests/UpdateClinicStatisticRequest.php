<?php

namespace App\Modules\ClinicStatistic\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClinicStatisticRequest extends FormRequest
{
    public function authorize(): bool
    {
        $stat = $this->route('clinic_statistic');
        return $this->user()->can('update', $stat);
    }

    public function rules(): array
    {
        return [
            'statistics_name' => ['sometimes', 'required', 'string', 'max:255'],
            'statistic_value' => ['sometimes', 'required', 'string', 'max:255'],
            'is_active'       => ['sometimes', 'boolean'],
        ];
    }
}
