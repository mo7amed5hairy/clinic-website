<?php

namespace App\Modules\Specification\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Specification\Models\Specification;
use App\Modules\Specification\Services\SpecificationService;
use Illuminate\Http\Request;

class SpecificationController extends Controller
{
    public function __construct(
        protected SpecificationService $service
    ) {}

    /**
     * جلب كل الـ Specifications
     */
    public function index()
    {
        return response()->json(
            $this->service->list()
        );
    }

    /**
     * إنشاء Specification جديد
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => ['required', 'string', 'min:2', 'max:200'],
            'description' => ['nullable', 'string'],
        ]);

        $specification = $this->service->store([
            'name'        => $validated['name'],
            'description' => $validated['description'] ?? null,
        ]);

        return response()->json($specification, 201);
    }

    /**
     * عرض Specification محدد
     */
    public function show(Specification $specification)
    {
        return response()->json($specification);
    }

    /**
     * تحديث Specification
     */
    public function update(Request $request, Specification $specification)
    {
        $validated = $request->validate([
            'name'        => ['sometimes', 'required', 'string', 'min:2', 'max:200'],
            'description' => ['nullable', 'string'],
        ]);

        $updated = $this->service->update($specification, $validated);

        return response()->json($updated);
    }

    /**
     * حذف Specification
     */
    public function destroy(Specification $specification)
    {
        $this->service->destroy($specification);

        return response()->json(['message' => __('Specification.deleted')]);
    }
}
