<?php

namespace App\Modules\ContactMessage\Repositories;

use App\Modules\ContactMessage\Contracts\ContactMessageRepositoryInterface;
use App\Modules\ContactMessage\Models\ContactMessage;

class ContactMessageRepository implements ContactMessageRepositoryInterface
{
    public function list(): array
    {
        return ContactMessage::all()->toArray();
    }

    public function show(int $id): ?ContactMessage
    {
        return ContactMessage::find($id);
    }

    public function store(array $data): ContactMessage
    {
        return ContactMessage::create($data);
    }

    public function update(ContactMessage $message, array $data): ContactMessage
    {
        $message->update($data);
        return $message;
    }

    public function destroy(ContactMessage $message): bool
    {
        return $message->delete();
    }
}
