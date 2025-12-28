<?php

namespace App\Modules\InsuranceCompany\GraphQL;

use GraphQL\Error\UserError;
use App\Modules\InsuranceCompany\Services\InsuranceCompanyService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class InsuranceCompanyResolver
{
    public function __construct(
        protected InsuranceCompanyService $service
    ) {}

    /**
     * جلب كل شركات التأمين
     */
    public function list($_, array $args)
    {
        return $this->service->list();
    }

    /**
     * جلب شركة تأمين محددة
     */
    public function show($_, array $args)
    {
        $company = $this->service->show($args['id']);

        if (!$company) {
            throw ValidationException::withMessages([
                'id' => [__('insurance_company.messages.not_found')],
            ]);
        }

        return $company;
    }

    /**
     * إنشاء شركة تأمين
     */
    public function create($_, array $args)
    {
        $validator = Validator::make(
            $args,
            [
                'name'      => ['required', 'string', 'max:255'],
                'link'      => ['nullable', 'url'],
                'is_active' => ['nullable', 'boolean'],
                'image'     => ['nullable'],
            ],
            [
                'name.required' => __('insurance_company.validation.name_required'),
                'link.url'      => __('insurance_company.validation.link_url'),
            ]
        );

        if ($validator->fails()) {
            throw new UserError(
                collect($validator->errors()->all())->join("\n")
            );
        }

        $data = $validator->validated();

        $company = $this->service->store(
            array_merge($data, [
                'tenant_id' => tenant('id'),
            ])
        );

        if (!empty($args['image'])) {
            $company->uploadImage($args['image'], [
                'folder' => 'insurance_companies/images',
                'column' => 'image',
            ]);
        }

        return $company->refresh();
    }

    /**
     * تحديث شركة تأمين
     */
    public function update($_, array $args)
    {
        $company = $this->service->show($args['id']);

        if (!$company) {
            throw ValidationException::withMessages([
                'id' => [__('insurance_company.messages.not_found')],
            ]);
        }

        $validator = Validator::make(
            $args,
            [
                'name'      => ['sometimes', 'required', 'string', 'max:255'],
                'link'      => ['sometimes', 'nullable', 'url'],
                'is_active' => ['sometimes', 'boolean'],
                'image'     => ['sometimes', 'nullable'],
            ],
            [
                'name.required' => __('insurance_company.validation.name_required'),
                'link.url'      => __('insurance_company.validation.link_url'),
            ]
        );

        if ($validator->fails()) {
            throw new UserError(
                collect($validator->errors()->all())->join("\n")
            );
        }

        $data = $validator->validated();
        $updateData = [];

        foreach (['name', 'link', 'is_active'] as $field) {
            if (array_key_exists($field, $data)) {
                $updateData[$field] = $data[$field];
            }
        }

        if (!empty($updateData)) {
            $this->service->update($company, $updateData);
        }

        if (!empty($args['image'])) {
            $company->replaceImage($args['image'], [
                'folder' => 'insurance_companies/images',
                'column' => 'image',
            ]);
        }

        return $company->refresh();
    }

    /**
     * حذف شركة تأمين
     */
    public function destroy($_, array $args)
    {
        $company = $this->service->show($args['id']);

        if (!$company) {
            throw ValidationException::withMessages([
                'id' => [__('insurance_company.messages.not_found')],
            ]);
        }

        $this->service->destroy($company);

        return true;
    }
}
