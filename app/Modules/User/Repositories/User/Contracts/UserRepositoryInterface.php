<?php

namespace App\Modules\User\Repositories\User\Contracts;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface UserRepositoryInterface
{
    public function create(array $data): User;

    public function findByEmail(string $email): ?User;

    public function findById(int $id): ?User;

    public function paginate(int $perPage = 15): LengthAwarePaginator;

    public function update(User $user, array $data): User;

    public function delete(User $user): bool;
}
