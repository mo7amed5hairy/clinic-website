<?php

namespace App\Modules\ClinicSchedule\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\ClinicSchedule\Services\ClinicScheduleService;
use App\Modules\ClinicSchedule\Http\Requests\StoreClinicScheduleRequest;
use App\Modules\ClinicSchedule\Http\Requests\UpdateClinicScheduleRequest;
use Illuminate\Http\JsonResponse;

class ClinicScheduleController extends Controller
{
    public function __construct(protected ClinicScheduleService $service) {}

    /**
     * جلب كل الجداول
     */
    public function index(): JsonResponse
    {
        $schedules = $this->service->list();
        return response()->json($schedules);
    }

    /**
     * إنشاء جدول جديد
     */
    public function store(StoreClinicScheduleRequest $request): JsonResponse
    {
        $schedule = $this->service->store(array_merge($request->validated(), [
            'tenant_id' => tenant('id')
        ]));

        return response()->json($schedule->refresh());
    }

    /**
     * جلب جدول محدد
     */
    public function show($id): JsonResponse
    {
        $schedule = $this->service->show($id);
        if (!$schedule) {
            return response()->json(['message' => __('ClinicSchedule.messages.not_found')], 404);
        }
        return response()->json($schedule);
    }

    /**
     * تحديث جدول
     */
    public function update(UpdateClinicScheduleRequest $request, $id): JsonResponse
    {
        $schedule = $this->service->show($id);
        if (!$schedule) {
            return response()->json(['message' => __('ClinicSchedule.messages.not_found')], 404);
        }

        $this->service->update($schedule, $request->validated());
        return response()->json($schedule->refresh());
    }

    /**
     * حذف جدول
     */
    public function destroy($id): JsonResponse
    {
        $schedule = $this->service->show($id);
        if (!$schedule) {
            return response()->json(['message' => __('ClinicSchedule.messages.not_found')], 404);
        }

        $this->service->destroy($schedule);
        return response()->json(['success' => true]);
    }
}
