<?php

namespace App\Modules\User\Services\User;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Modules\User\Repositories\User\Contracts\UserRepositoryInterface;
use App\Modules\Clinic\Models\Clinic;

class AuthService
{
    public function __construct(
        protected UserRepositoryInterface $userRepository
    ) {}

    /**
     * Register new user
     */
    public function register(array $data): array
    {
        // 1️⃣ Check if email exists
        if ($this->userRepository->findByEmail($data['email'])) {
            throw ValidationException::withMessages([
                'email' => __('auth.email_exists'),
            ]);
        }

        // 2️⃣ Create Clinic
        $clinic = Clinic::create([
            'tenant_id' => tenant('id'),
            'name'      => $data['name'] . "'s Clinic",
        ]);

        // 3️⃣ Create user
        $user = $this->userRepository->create([
            'tenant_id'     => tenant('id'),
            'name'          => $data['name'],
            'email'         => $data['email'],
            'phone'         => $data['phone'] ?? null,
            'password'      => Hash::make($data['password']),
            'clinic_id'     => $clinic->id,
        ]);

        // 3️⃣ Create Sanctum token
        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'user'  => $user,
            'token' => $token,
        ];
    }

    /**
     * Login user
     */
    public function login(array $data): array
    {
        $user = $this->userRepository->findByEmail($data['email']);

        if (! $user || ! Hash::check($data['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => __('auth.invalid_credentials'),
            ]);
        }

        // Optional: revoke old tokens
        $user->tokens()->delete();

        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'user'  => $user,
            'token' => $token,
        ];
    }

    /**
     * Logout user
     */
    public function logout(User $user): void
    {
        $user->tokens()->delete();
    }
}
