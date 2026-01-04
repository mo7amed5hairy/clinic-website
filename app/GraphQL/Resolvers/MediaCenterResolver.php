<?php

namespace App\GraphQL\Resolvers;

use GraphQL\Error\UserError;
use App\Modules\MediaCenter\Services\MediaCenterService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class MediaCenterResolver
{
    public function __construct(protected MediaCenterService $service) {}

    public function list()
    {
        return $this->service->list();
    }

    public function show($_, array $args)
    {
        $media = $this->service->show($args['id']);
        if (!$media) {
            throw ValidationException::withMessages(['id' => ['Media not found']]);
        }
        return $media;
    }

    public function create($_, array $args)
    {
        $validator = Validator::make($args, [
            'type'      => ['required', 'in:image,video'],
            'files'     => ['required', 'array'],
        ]);

        if ($validator->fails()) {
            throw new UserError(collect($validator->errors()->all())->join("\n"));
        }

        $data = $validator->validated();
        $data['tenant_id'] = tenant('id');

        $media = $this->service->store($data);

        return $media;
    }

    public function update($_, array $args)
    {
        $media = $this->service->show($args['id']);
        if (!$media) {
            throw ValidationException::withMessages(['id' => ['Media not found']]);
        }

        $validator = Validator::make($args, [
            'type'      => ['sometimes', 'in:image,video'],
            'files'     => ['sometimes', 'array'],
        ]);

        if ($validator->fails()) {
            throw new UserError(collect($validator->errors()->all())->join("\n"));
        }

        $data = $validator->validated();
        $this->service->update($media, $data);

        return $media->refresh();
    }

    public function destroy($_, array $args)
    {
        $media = $this->service->show($args['id']);
        if (!$media) {
            throw ValidationException::withMessages(['id' => ['Media not found']]);
        }

        $this->service->destroy($media);
        return true;
    }
}

