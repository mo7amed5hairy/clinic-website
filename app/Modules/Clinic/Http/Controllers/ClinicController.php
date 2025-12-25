<?php

namespace App\Modules\Clinic\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Clinic\Models\Clinic;
use App\Modules\Clinic\Services\ClinicService;
use App\Modules\Clinic\Http\Requests\StoreClinicRequest;
use App\Modules\Clinic\Http\Requests\UpdateClinicRequest;

class ClinicController extends Controller
{
    public function __construct(
        protected ClinicService $service
    ) {}

    /**
     * جلب كل العيادات
     */
    public function index()
    {
        return response()->json(
            $this->service->list()
        );
    }

    /**
     * إنشاء عيادة
     */
    public function store(StoreClinicRequest $request)
    {
        $clinic = $this->service->store([
            'tenant_id' => tenant('id'),
            'name'      => $request->name,
            'color'     => $request->color,
            'is_active' => $request->boolean('is_active', true),
        ]);

        // رفع اللوجو (اختياري)
        if ($request->hasFile('logo')) {
            $clinic->uploadImage(
                $request->file('logo'),
                [
                    'folder' => 'clinics/logos',
                    'column' => 'logo',
                ]
            );
        }

        return response()->json($clinic, 201);
    }

    /**
     * عرض عيادة واحدة
     */
    public function show(Clinic $clinic)
    {
        return response()->json($clinic);
    }

    /**
     * تحديث عيادة
     */
    public function update(UpdateClinicRequest $request, Clinic $clinic)
    {
        $clinic = $this->service->update(
            $clinic,
            $request->validated()
        );

        if ($request->hasFile('logo')) {
            $clinic->uploadImage(
                $request->file('logo'),
                [
                    'folder' => 'clinics/logos',
                    'column' => 'logo',
                ]
            );
        }

        return response()->json($clinic);
    }

    /**
     * حذف عيادة
     */
    public function destroy(Clinic $clinic)
    {
        $this->service->destroy($clinic);

        return response()->json([
            'message' => __('clinic.deleted'),
        ]);
    }
}
