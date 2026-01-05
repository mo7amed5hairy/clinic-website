<?php

namespace App\Modules\User\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Modules\User\Services\User\AuthService;
use App\Modules\User\Requests\User\LoginRequest;
use App\Modules\User\Requests\User\RegisterRequest;
use App\Modules\User\Resources\User\UserResource;

class AuthController extends Controller
{
    public function __construct(
        protected AuthService $authService
    ) {}

    public function register(RegisterRequest $request): JsonResponse
    {
        $result = $this->authService->register($request->validated());

        return response()->json([
            'status'  => true,
            'message' => __('Auth/messages.register_success'),
            'data'    => [
                'user'  => new UserResource($result['user']),
                'token' => $result['token'],
            ],
        ], 201);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $result = $this->authService->login($request->validated());

        return response()->json([
            'status'  => true,
            'message' => __('Auth/messages.login_success'),
            'data'    => [
                'user'  => new UserResource($result['user']),
                'token' => $result['token'],
            ],
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        $this->authService->logout($request->user());

        return response()->json([
            'status'  => true,
            'message' => __('Auth/messages.logout_success'),
        ]);
    }

    public function me(Request $request): JsonResponse
    {
        return response()->json([
            'status' => true,
            'data'   => new UserResource($request->user()),
        ]);
    }
}
