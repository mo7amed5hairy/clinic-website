<?php

namespace App\Modules\Doctor\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Doctor\Models\Doctor;
use App\Modules\Doctor\Services\DoctorService;
use App\Modules\Doctor\Http\Requests\StoreDoctorRequest;
use App\Modules\Doctor\Http\Requests\UpdateDoctorRequest;

class DoctorController extends Controller
{
    public function __construct(
        protected DoctorService $service
    ) {}

    public function index()
    {
        return response()->json(
            $this->service->list()
        );
    }

    public function store(StoreDoctorRequest $request)
    {
        $doctor = $this->service->store([
            'tenant_id'   => tenant('id'),
            'doctor_data' => $request->doctor_data,
            'is_active'   => $request->boolean('is_active', true),
        ]);

        // $doctor->uploadImageAsync(
        //     $request->file('image'),
        //     'doctors/images',
        //     'doctor_data->image'
        // );

        $doctor->uploadImage(
            $request->file('image'),
            [
                'folder' => 'doctors/images',
                'column' => 'doctor_data->image',
            ]
        );



        return response()->json($doctor, 201);
    }

    public function show(Doctor $doctor)
    {
        return response()->json($doctor);
    }

    public function update(UpdateDoctorRequest $request, Doctor $doctor)
    {
        return response()->json(
            $this->service->update($doctor, $request->validated())
        );
    }

    public function destroy(Doctor $doctor)
    {
        $this->service->destroy($doctor);
        return response()->json(['message' => __('doctor.deleted')]);
    }
}
