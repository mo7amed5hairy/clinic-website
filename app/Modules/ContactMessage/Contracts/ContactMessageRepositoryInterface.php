<?php

namespace App\Modules\ContactMessage\Contracts;

use App\Modules\ContactMessage\Models\ContactMessage;

interface ContactMessageRepositoryInterface
{
    public function list(): array;

    public function show(int $id): ?ContactMessage;

    public function store(array $data): ContactMessage;

    public function update(ContactMessage $message, array $data): ContactMessage;

    public function destroy(ContactMessage $message): bool;
}
