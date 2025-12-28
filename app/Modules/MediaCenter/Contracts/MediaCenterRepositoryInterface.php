<?php

namespace App\Modules\MediaCenter\Contracts;

interface MediaCenterRepositoryInterface
{
    public function all();

    public function find($id);

    public function create(array $data);

    public function update($media, array $data);

    public function delete($media);
}
