<?php

namespace App\Modules\MediaCenter\Services;

use App\Modules\MediaCenter\Contracts\MediaCenterRepositoryInterface;

class MediaCenterService
{
    public function __construct(protected MediaCenterRepositoryInterface $repo) {}

    public function list()
    {
        return $this->repo->all();
    }

    public function show($id)
    {
        return $this->repo->find($id);
    }

    public function store(array $data)
    {
        return $this->repo->create($data);
    }

    public function update($media, array $data)
    {
        return $this->repo->update($media, $data);
    }

    public function destroy($media)
    {
        return $this->repo->delete($media);
    }
}
