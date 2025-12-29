<?php

namespace App\Modules\ClinicSection\Repositories;

use App\Modules\ClinicSection\Contracts\ClinicSectionRepositoryInterface;
use App\Modules\ClinicSection\Models\ClinicSection;

class ClinicSectionRepository implements ClinicSectionRepositoryInterface
{
    public function allByClinic(int $clinicId)
    {
        return ClinicSection::with('items')
            ->where('clinic_id', $clinicId)
            ->get();
    }

    public function find(int $id)
    {
        return ClinicSection::with('items')->find($id);
    }

    public function create(array $data)
    {
        $items = $data['items'] ?? [];
        unset($data['items']);

        $section = ClinicSection::create($data);

        if (!empty($items)) {
            $section->items()->createMany($items);
        }

        return $section->load('items');
    }

    public function update($section, array $data)
    {
        $items = $data['items'] ?? null;
        unset($data['items']);

        $section->update($data);

        if (is_array($items)) {
            $section->items()->delete();
            $section->items()->createMany($items);
        }

        return $section->load('items');
    }

    public function delete($section)
    {
        return $section->delete();
    }
}
