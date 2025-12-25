<?php

namespace App\Modules\Doctor\GraphQL;

use GraphQL\Error\UserError;
use Illuminate\Http\UploadedFile;
use App\Modules\Doctor\Models\Doctor;
use App\Modules\Doctor\Services\DoctorService;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

class DoctorResolver
{
    public function __construct(
        protected DoctorService $service
    ) {}

    /**
     * جلب كل الدكاترة
     */
    public function list($_, array $args)
    {
        return $this->service->list();
    }

    /**
     * جلب دكتور محدد
     */
    public function show($_, array $args)
    {
        $doctor = $this->service->show($args['id']);

        if (!$doctor) {
            $validator = Validator::make([], []);
            $validator->errors()->add(
                'id',
                __('doctor.messages.not_found')
            );

            throw new ValidationException($validator);
        }

        return $doctor;
    }


    /**
     * إنشاء دكتور
     */
    public function create($_, array $args)
    {
        $validator = Validator::make(
            $args,
            [
                'doctor_data.name'           => ['required', 'string', 'min:2'],
                'doctor_data.specialization' => ['required', 'string'],
                'doctor_data.experience'     => ['required', 'string'],
                'image'                      => ['nullable', 'image', 'max:10240'],
            ],
            [
                'doctor_data.name.required' =>
                __('doctor.validation.name_required', [
                    'attribute' => __('doctor.fields.name'),
                ]),

                'doctor_data.specialization.required' =>
                __('doctor.validation.specialization_required', [
                    'attribute' => __('doctor.fields.specialization'),
                ]),

                'doctor_data.experience.required' =>
                __('doctor.validation.experience_required', [
                    'attribute' => __('doctor.fields.experience'),
                ]),
            ]
        );



        if ($validator->fails()) {
            throw new UserError(
                collect($validator->errors()->all())->join("\n")
            );
        }

        $data = $validator->validated();

        $doctor = $this->service->store([
            'tenant_id'   => tenant('id'),
            'doctor_data' => $data['doctor_data'],
            'is_active'   => $data['is_active'] ?? true,
        ]);

        if (!empty($data['image']) && $data['image'] instanceof UploadedFile) {
            $doctor->replaceImage($data['image'], [
                'folder' => 'doctors/images',
                'column' => 'doctor_data->image',
            ]);
            $doctor->refresh();
        }

        return $doctor;
    }

    /**
     * تحديث دكتور
     */
    public function update($_, array $args)
    {
        /** @var Doctor $doctor */
        $doctor = $this->service->show($args['id']);


        $validator = Validator::make(
            $args,
            [
                'doctor_data' => ['nullable', 'array'],

                'doctor_data.name'           => ['sometimes', 'required', 'string', 'min:2'],
                'doctor_data.specialization' => ['sometimes', 'required', 'string', 'min:2'],
                'doctor_data.experience'     => ['sometimes', 'required', 'string', 'min:1'],

                'is_active' => ['nullable', 'boolean'],
                'image'     => ['nullable', 'file', 'image', 'max:10240'],
            ],
            [
                'doctor_data.name.required' =>
                __('doctor.validation.name_required', [
                    'attribute' => __('doctor.fields.name'),
                ]),

                'doctor_data.specialization.required' =>
                __('doctor.validation.specialization_required', [
                    'attribute' => __('doctor.fields.specialization'),
                ]),

                'doctor_data.experience.required' =>
                __('doctor.validation.experience_required', [
                    'attribute' => __('doctor.fields.experience'),
                ]),
            ]
        );



        if ($validator->fails()) {
            throw new UserError(
                collect($validator->errors()->all())->join("\n")
            );
        }

        $data = $validator->validated();

        $updateData = [];

        if (array_key_exists('doctor_data', $data)) {
            $updateData['doctor_data'] = $data['doctor_data'];
        }

        if (array_key_exists('is_active', $data)) {
            $updateData['is_active'] = $data['is_active'];
        }

        if (!empty($updateData)) {
            $this->service->update($doctor, $updateData);
        }

        if (!empty($data['image']) && $data['image'] instanceof UploadedFile) {
            $doctor->replaceImage($data['image'], [
                'folder' => 'doctors/images',
                'column' => 'doctor_data->image',
            ]);
            $doctor->refresh();
        }

        return $doctor;
    }

    /**
     * حذف دكتور
     */


    public function destroy($_, array $args)
    {
        $doctor = $this->service->show($args['id']);

        if (!$doctor) {
            $validator = Validator::make(
                ['id' => $args['id']],
                ['id' => ['required']],
                [
                    'id.required' => __('doctor.messages.not_found'),
                ]
            );

            throw new ValidationException($validator);
        }

        $this->service->destroy($doctor);

        return true;
    }
}
