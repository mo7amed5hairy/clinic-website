<?php

namespace App\Modules\HeroSection\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\HeroSection\Services\HeroSectionService;
use App\Modules\HeroSection\Http\Requests\StoreHeroSectionRequest;
use App\Modules\HeroSection\Http\Requests\UpdateHeroSectionRequest;
use App\Modules\HeroSection\Models\HeroSection;

class HeroSectionController extends Controller
{
    public function __construct(protected HeroSectionService $service) {}

    public function index()
    {
        return $this->service->list();
    }

    public function show($id)
    {
        return $this->service->show($id);
    }

    public function store(StoreHeroSectionRequest $request)
    {
        $data = $request->validated();
        $data['tenant_id'] = tenant('id');
        return $this->service->store($data);
    }

    public function update(UpdateHeroSectionRequest $request, HeroSection $heroSection)
    {
        return $this->service->update($heroSection, $request->validated());
    }

    public function destroy(HeroSection $heroSection)
    {
        return $this->service->destroy($heroSection);
    }
}
