<?php

namespace App\Modules\ClinicStatistic\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\ClinicStatistic\Models\ClinicStatistic;
use App\Modules\ClinicStatistic\Services\ClinicStatisticService;
use App\Modules\ClinicStatistic\Http\Requests\StoreClinicStatisticRequest;
use App\Modules\ClinicStatistic\Http\Requests\UpdateClinicStatisticRequest;

class ClinicStatisticController extends Controller
{
    
 public function __construct(protected ClinicStatisticService $service) {}

    public function index()
    {
        return $this->service->list();
    }

    public function show(ClinicStatistic $clinic_statistic)
    {
        return $clinic_statistic;
    }

    public function store(StoreClinicStatisticRequest $request)
    {
        $data = $request->validated();
        $data['tenant_id'] = tenant('id');

        $stat = $this->service->store($data);

        return $stat->refresh();
    }

    public function update(UpdateClinicStatisticRequest $request, ClinicStatistic $clinic_statistic)
    {
        $data = $request->validated();
        $stat = $this->service->update($clinic_statistic, $data);

        return $stat->refresh();
    }

    public function destroy(ClinicStatistic $clinic_statistic)
    {
        $this->service->destroy($clinic_statistic);
        return response()->json(['success' => true]);
    }
}
