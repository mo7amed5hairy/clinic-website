<?php

namespace App\GraphQL\Resolvers;

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
    public function show($_, array $args)
    {
        $user = auth()->guard('sanctum')->user();
        if (!$user || !$user->clinic_id) {
             throw new UserError(__('doctor.messages.no_clinic'));
        }
        return $this->service->getByClinicId($user->clinic_id);
    }


    /**
     * إنشاء دكتور
     */
    public function createOrUpdate($_, array $args)
    {
        $user = auth()->guard('sanctum')->user();
        if (!$user || !$user->clinic_id) {
             throw new UserError(__('doctor.messages.no_clinic'));
        }

        $validator = Validator::make($args, [
            'name'           => ['required', 'string', 'min:2'],
            'specialization' => ['required', 'string'],
            'experience'     => ['required', 'string'],
            'image'          => ['nullable'],
            'departments'    => ['nullable', 'array'],
            'departments.*.name' => ['required', 'string'],
            'departments.*.content' => ['nullable', 'string'],
        ]);

        if ($validator->fails()) {
            throw new UserError(collect($validator->errors()->all())->join("\n"));
        }

        $data = $validator->validated();
        $data['tenant_id'] = tenant('id');
        
        // Pass ID if exists in args (for update)
        if (isset($args['id'])) {
            $data['id'] = $args['id'];
        }

        $doctor = $this->service->createOrUpdate($user->clinic_id, $data);

        if (!empty($args['image'])) {
            $doctor->replaceImage($args['image'], [
                'folder' => 'doctors/images',
                'column' => 'image',
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
        $user = auth()->guard('sanctum')->user();
        if (!$user || !$user->clinic_id) {
             throw new UserError(__('doctor.messages.no_clinic'));
        }

        $doctor = $this->service->show($args['id']); 

        if (!$doctor || $doctor->clinic_id != $user->clinic_id) {
            throw new UserError(__('doctor.messages.not_found'));
        }

        $this->service->destroy($doctor);
        return true;
    }
}

