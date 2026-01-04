<?php

namespace App\GraphQL\Resolvers;

use GraphQL\Error\UserError;
use App\Modules\InstallmentMethod\Services\InstallmentMethodService;
use Illuminate\Support\Facades\Validator;

class InstallmentMethodResolver
{
    public function __construct(protected InstallmentMethodService $service) {}

    public function show($_, array $args)
    {
        return $this->service->all();
    }

    public function createOrUpdate($_, array $args)
    {
        $validator = Validator::make($args, [
            'id'    => ['nullable', 'exists:installment_methods,id'],
            'name'  => ['required', 'string', 'max:255'],
            'link'  => ['nullable', 'string', 'url', 'max:255'],
            'image' => ['nullable', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
             throw new UserError(collect($validator->errors()->all())->join("\n"));
        }

        $data = $validator->validated();
        
        return $this->service->createOrUpdate($data);
    }

    public function destroy($_, array $args)
    {
        $method = $this->service->show($args['id']);
        
        if (!$method) {
            throw new UserError('Not Found');
        }

        $this->service->destroy($method);

        return true;
    }
}
