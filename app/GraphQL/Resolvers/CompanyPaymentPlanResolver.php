<?php

namespace App\GraphQL\Resolvers;

use GraphQL\Error\UserError;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Modules\CompanyPaymentPlan\Services\CompanyPaymentPlanService;

class CompanyPaymentPlanResolver
{
    public function __construct(
        protected CompanyPaymentPlanService $service
    ) {}

    public function list()
    {
        return $this->service->list();
    }

    public function show($_, array $args)
    {
        $plan = $this->service->show($args['id']);

        if (!$plan) {
            throw ValidationException::withMessages([
                'id' => [__('company_payment_plan.messages.not_found')]
            ]);
        }

        return $plan;
    }

    public function create($_, array $args)
    {
        $validator = Validator::make($args, [
            'insurance_company_id' => ['required', 'exists:insurance_companies,id'],
            'is_active'            => ['nullable', 'boolean'],
        ], [
            'insurance_company_id.required' => __('company_payment_plan.validation.insurance_company_required'),
            'insurance_company_id.exists'   => __('company_payment_plan.validation.insurance_company_exists'),
        ]);

        if ($validator->fails()) {
            throw new UserError(collect($validator->errors()->all())->join("\n"));
        }

        $data = $validator->validated();
        $data['tenant_id'] = tenant('id');

        return $this->service->store($data);
    }

    public function update($_, array $args)
    {
        $plan = $this->service->show($args['id']);

        if (!$plan) {
            throw ValidationException::withMessages([
                'id' => [__('company_payment_plan.messages.not_found')]
            ]);
        }

        $validator = Validator::make($args, [
            'insurance_company_id' => ['sometimes', 'required', 'exists:insurance_companies,id'],
            'is_active'            => ['sometimes', 'boolean'],
        ]);

        if ($validator->fails()) {
            throw new UserError(collect($validator->errors()->all())->join("\n"));
        }

        return $this->service->update($plan, $validator->validated());
    }

    public function destroy($_, array $args)
    {
        $plan = $this->service->show($args['id']);

        if (!$plan) {
            throw ValidationException::withMessages([
                'id' => [__('company_payment_plan.messages.not_found')]
            ]);
        }

        $this->service->destroy($plan);
        return true;
    }
}

