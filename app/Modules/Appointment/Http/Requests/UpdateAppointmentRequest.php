<?php

namespace App\Modules\Appointment\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAppointmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id' => ['required', 'exists:appointments,id'],
            'patient_name' => ['sometimes', 'string'],
            'patient_phone' => ['sometimes', 'string'],
            'patient_email' => ['nullable', 'email'],
            'doctor_name' => ['nullable', 'string'],
            'service_name' => ['sometimes', 'string'],
            'appointment_date' => ['sometimes', 'date'],
            'appointment_time' => ['sometimes'],
            'status' => ['sometimes', 'string'],
        ];
    }

    public function attributes(): array
    {
        return [
            'id' => __('modules.appointment.id'),
            'patient_name' => __('modules.appointment.patient_name'),
            'patient_phone' => __('modules.appointment.patient_phone'),
        ];
    }
}
