<?php

namespace App\Modules\Unit;

use App\Http\Controllers\Controller;
use App\Modules\Unit\Services\UnitService;
use App\Modules\Unit\Requests\StoreUnitRequest;
use App\Modules\Unit\Requests\UpdateUnitRequest;

class UnitController extends Controller
{
    public function __construct(protected UnitService $service) {}

    public function index() { return $this->service->list(); }

    public function show($id) { return $this->service->show($id); }

    public function store(StoreUnitRequest $request) { return $this->service->store($request->validated()); }

    public function update(UpdateUnitRequest $request, $id)
    {
        $unit = $this->service->show($id);
        return $this->service->update($unit, $request->validated());
    }

    public function destroy($id)
    {
        $unit = $this->service->show($id);
        return $this->service->destroy($unit);
    }
}
