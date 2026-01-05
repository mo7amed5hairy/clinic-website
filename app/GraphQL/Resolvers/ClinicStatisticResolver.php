<?php

namespace App\GraphQL\Resolvers;

use GraphQL\Error\UserError;
use App\Modules\ClinicStatistic\Models\ClinicStatistic;
use App\Modules\ClinicStatistic\Services\ClinicStatisticService;
use Illuminate\Support\Facades\Validator;

class ClinicStatisticResolver
{
    public function __construct(protected ClinicStatisticService $service) {}

    // عرضالإحصائيات
    public function show($_, array $args)
    {
        // Publicly accessible, automatically scoped by tenant trait
        return ClinicStatistic::first();
    }

    // إنشاء أو تحديث الإحصائيات
    public function createOrUpdate($_, array $args)
    {
        $user = auth()->guard('sanctum')->user();
        if (!$user || !$user->clinic_id) {
            throw new UserError(__('ClinicStatistic/messages.no_clinic'));
        }

        // ✅ Validation متوافق مع الحقول اللي انت بتبعتها
        $validator = Validator::make($args, [
            'items' => ['required', 'array', 'max:4'],
            'items.*.statisitics_name' => ['required', 'string'],
            'items.*.statisitics_no' => ['required', 'string'],
        ]);


        if ($validator->fails()) {
            throw new UserError(collect($validator->errors()->all())->join("\n"));
        }

        $data = [
            'items' => $args['items'],
        ];
        // tenant_id is automatic via trait

        return $this->service->createOrUpdate($user->clinic_id, $data);
    }

    // حذف الإحصائيات
    public function destroy($_, array $args)
    {
        $user = auth()->guard('sanctum')->user();
        if (!$user || !$user->clinic_id) {
            throw new UserError(__('ClinicStatistic/messages.no_clinic'));
        }

        $stat = $this->service->getByClinicId($user->clinic_id);

        if ($stat) {
            $this->service->destroy($stat);
        }

        return true;
    }
}
