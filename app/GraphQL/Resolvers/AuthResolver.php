<?php

namespace App\GraphQL\Resolvers;

use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use App\Modules\User\Services\User\AuthService;
use App\Modules\User\Resources\User\UserResource;
use Illuminate\Support\Facades\Auth;
use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Support\Facades\Hash;
use App\Models\VerificationCode;


class AuthResolver
{
    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    // --- تسجيل مستخدم جديد ---
    public function register($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $validated = $args['input'] ?? [];

        $validator = \Illuminate\Support\Facades\Validator::make($validated, [
            'email' => 'required|email:rfc,dns|unique:users,email',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'password' => 'required|confirmed|min:8',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $result = $this->authService->register($validated);

        return [
            'status' => true,
            'message' => __('auth.register_success'),
            'user' => new UserResource($result['user']),
            'token' => $result['token'],
        ];
    }

    // --- تسجيل الدخول ---
    public function login($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $validated = $args['input'] ?? [];

        $validator = \Illuminate\Support\Facades\Validator::make($validated, [
            'email' => 'required|email:rfc,dns',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $result = $this->authService->login($validated);

        return [
            'status' => true,
            'message' => __('auth.login_success'),
            'user' => new UserResource($result['user']),
            'token' => $result['token'],
        ];
    }

    // --- تسجيل الخروج ---
    public function logout($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $user = Auth::guard('sanctum')->user();
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

    // --- بيانات المستخدم الحالي ---
    public function me($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $user = Auth::user();

        return [
            'status' => true,
            'user' => new UserResource($user),
        ];
    }

    // --- Forgot Password (Email فقط) ---
    public function forgotPassword($root, array $args)
    {
        $email = $args['input']['email'] ?? null;

        if (!$email) {
            throw ValidationException::withMessages([
                'email' => __('auth.email_required'),
            ]);
        }

        $this->authService->forgotPassword($email);

        return [
            'status' => true,
            'message' => __('auth.otp_sent'),
        ];
    }

    // --- Verify OTP ---
    public function verifyOtp($root, array $args)
    {
        $email = $args['input']['email'] ?? null;
        $code  = $args['input']['code'] ?? null;

        if (!$email || !$code) {
            throw ValidationException::withMessages([
                'email' => __('auth.email_required'),
                'code'  => __('auth.code_required'),
            ]);
        }

        $result = $this->authService->verifyOtp($email, $code);

        return [
            'status' => $result['status'],
            'message' => $result['message'],
            'token' => $result['token'],
        ];
    }




    public function resetPassword($root, array $args)
    {
        $input = $args['input'] ?? [];

        // 🔹 Validation
        $validator = \Validator::make($input, [
            'password' => 'required|string|min:8|confirmed',
            'token'    => 'required|string',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $result = $this->authService->resetPassword($input);

        return [
            'status'  => $result['status'],
            'message' => $result['message'],
        ];
    }



    // --- Resend OTP ---
    public function resendOtp($root, array $args)
    {
        $email = $args['input']['email'] ?? null;

        if (!$email) {
            throw ValidationException::withMessages([
                'email' => __('auth.email_required'),
            ]);
        }

        $this->authService->resendOtp($email);

        return [
            'status' => true,
            'message' => __('auth.otp_sent'),
        ];
    }
}
