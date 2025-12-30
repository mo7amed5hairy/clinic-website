<?php

namespace App\Modules\User\GraphQL;

use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use App\Modules\User\Services\User\AuthService;
use App\Modules\User\Resources\User\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\UploadedFile;
use GraphQL\Type\Definition\ResolveInfo;

class AuthResolver
{
    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * تسجيل مستخدم جديد
     */
    public function register($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $validated = $args['input'] ?? [];
        $result = $this->authService->register($validated);

        return [
            'status' => true,
            'message' => __('auth.register_success'),
            'user' => new UserResource($result['user']),
            'token' => $result['token'],
        ];
    }

    /**
     * تسجيل الدخول
     */
    public function login($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $validated = $args['input'] ?? [];
        $result = $this->authService->login($validated);

        return [
            'status' => true,
            'message' => __('auth.login_success'),
            'user' => new UserResource($result['user']),
            'token' => $result['token'],
        ];
    }

    /**
     * تسجيل الخروج
     */
    public function logout($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $user = Auth::user();
        $this->authService->logout($user);

        return [
            'status' => true,
            'message' => __('auth.logout_success'),
        ];
    }

    /**
     * جلب بيانات المستخدم الحالي
     */
    public function me($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $user = Auth::user();

        return [
            'status' => true,
            'user' => new UserResource($user),
        ];
    }
}
