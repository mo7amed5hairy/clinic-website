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


    public function __construct(
        protected AuthService $authService,
        protected \App\Modules\User\Services\User\ResetPasswordService $resetPasswordService
    ) {}

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
        $user = Auth::guard('sanctum')->user(); // أو guard اللي انت عامل فيه login
        if (!$user) {
            return [
                'status' => false,
                'message' => __('auth.not_logged_in'),
            ];
        }

        $this->authService->logout($user);

        return [
            'status' => true,
            'message' => __('auth.logout_success'),
        ];
    }


    /**
     * جلب بيانات المستخدم الحالي
     */
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

    /**
     * Forgot Password
     */
    public function forgotPassword($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        return $this->resetPasswordService->sendCode($args['email']);
    }

    /**
     * Reset Password
     */
    public function resetPassword($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $input = $args['input'];
        return $this->resetPasswordService->reset($input['email'], $input['code'], $input['password']);
    }
}
