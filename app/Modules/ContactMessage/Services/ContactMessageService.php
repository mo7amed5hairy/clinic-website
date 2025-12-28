<?php

namespace App\Modules\ContactMessage\Services;

use App\Modules\ContactMessage\Contracts\ContactMessageRepositoryInterface;
use App\Modules\ContactMessage\Models\ContactMessage;

class ContactMessageService
{
    public function __construct(
        protected ContactMessageRepositoryInterface $repo
    ) {}

    public function list(): array
    {
        return $this->repo->list();
    }

    public function show(int $id): ?ContactMessage
    {
        return $this->repo->show($id);
    }

    public function store(array $data): ContactMessage
    {
        return $this->repo->store($data);
    }

    public function update(ContactMessage $message, array $data): ContactMessage
    {
        return $this->repo->update($message, $data);
    }

    public function destroy(ContactMessage $message): bool
    {
        return $this->repo->destroy($message);
    }
}
