<?php

namespace App\Modules\ContactMessage\GraphQL;

use GraphQL\Error\UserError;
use App\Modules\ContactMessage\Services\ContactMessageService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ContactMessageResolver
{
    public function __construct(protected ContactMessageService $service) {}

    public function list($_, array $args)
    {
        return $this->service->list();
    }

    public function show($_, array $args)
    {
        $message = $this->service->show($args['id']);

        if (!$message) {
            throw ValidationException::withMessages([
                'id' => [__('contact_message.messages.not_found')]
            ]);
        }

        return $message;
    }

    public function create($_, array $args)
    {
        $validator = Validator::make($args, [
            'name'    => ['required', 'string', 'max:255'],
            'email'   => ['nullable', 'email'],
            'phone'   => ['nullable', 'string', 'max:255'],
            'subject' => ['nullable', 'string', 'max:255'],
            'message' => ['required', 'string'],
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
        $message = $this->service->show($args['id']);

        if (!$message) {
            throw ValidationException::withMessages([
                'id' => [__('contact_message.messages.not_found')]
            ]);
        }

        $validator = Validator::make($args, [
            'name'    => ['sometimes', 'required', 'string', 'max:255'],
            'email'   => ['nullable', 'email'],
            'phone'   => ['nullable', 'string', 'max:255'],
            'subject' => ['nullable', 'string', 'max:255'],
            'message' => ['sometimes', 'required', 'string'],
        ]);

        if ($validator->fails()) {
            throw new UserError(collect($validator->errors()->all())->join("\n"));
        }

        return $this->service->update($message, $validator->validated());
    }

    public function destroy($_, array $args)
    {
        $message = $this->service->show($args['id']);

        if (!$message) {
            throw ValidationException::withMessages([
                'id' => [__('contact_message.messages.not_found')]
            ]);
        }

        return $this->service->destroy($message);
    }
}
