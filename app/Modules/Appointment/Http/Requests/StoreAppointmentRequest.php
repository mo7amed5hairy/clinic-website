<?php

namespace App\Modules\Appointment\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAppointmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'patient_name' => ['required', 'string'],
            'patient_phone' => ['required', 'string'],
            'patient_email' => ['nullable', 'email'],
            'doctor_name' => ['nullable', 'string'],
            'service_name' => ['required', 'string'],
            'appointment_date' => ['required', 'date'],
            'appointment_time' => ['required'],
            'status' => ['nullable', 'string'],
        ];
    }

    public function attributes(): array
    {
        return [
            'patient_name' => __('modules.appointment.patient_name'),
            'patient_phone' => __('modules.appointment.patient_phone'),
            'patient_email' => __('modules.appointment.patient_email'),
            'doctor_name' => __('modules.appointment.doctor_name'),
            'service_name' => __('modules.appointment.service_name'),
            'appointment_date' => __('modules.appointment.appointment_date'),
            'appointment_time' => __('modules.appointment.appointment_time'),
            'status' => __('modules.appointment.status'),
        ];
    }
}
