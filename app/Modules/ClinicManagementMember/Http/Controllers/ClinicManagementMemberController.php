<?php

namespace App\Modules\ClinicManagementMember\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\ClinicManagementMember\Models\ClinicManagementMember;
use App\Modules\ClinicManagementMember\Services\ClinicManagementMemberService;
use App\Modules\ClinicManagementMember\Http\Requests\StoreClinicManagementMemberRequest;
use App\Modules\ClinicManagementMember\Http\Requests\UpdateClinicManagementMemberRequest;

class ClinicManagementMemberController extends Controller
{
    public function __construct(
        protected ClinicManagementMemberService $service
    ) {}

    public function index()
    {
        return response()->json(
            $this->service->list()
        );
    }

    public function store(StoreClinicManagementMemberRequest $request)
    {
        $member = $this->service->store([
            'tenant_id' => tenant('id'),
            ...$request->validated(),
        ]);

        return response()->json($member, 201);
    }

    public function show(ClinicManagementMember $clinicManagementMember)
    {
        return response()->json($clinicManagementMember);
    }

    public function update(
        UpdateClinicManagementMemberRequest $request,
        ClinicManagementMember $clinicManagementMember
    ) {
        return response()->json(
            $this->service->update($clinicManagementMember, $request->validated())
        );
    }

    public function destroy(ClinicManagementMember $clinicManagementMember)
    {
        $this->service->destroy($clinicManagementMember);
        return response()->json(['message' => __('ClinicManagementMember.messages.deleted')]);
    }
}
