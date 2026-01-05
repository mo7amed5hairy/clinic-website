<?php

namespace App\Modules\User\Services\User;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Modules\User\Repositories\User\Contracts\UserRepositoryInterface;
use App\Modules\Clinic\Contracts\ClinicRepositoryInterface;
use App\Modules\Clinic\Models\Clinic;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\PersonalAccessToken;
use App\Models\VerificationCode;

class AuthService
{
    public function __construct(
        protected UserRepositoryInterface $userRepository,
        protected ClinicRepositoryInterface $clinicRepository
    ) {}

    /**
     * Register new user
     */
    public function register(array $data): array
    {
        return DB::transaction(function () use ($data) {
            // 1️⃣ Check if email exists
            if ($this->userRepository->findByEmail($data['email'])) {
                throw ValidationException::withMessages([
                    'email' => __('auth.email_exists'),
                ]);
            }

            // 2️⃣ Create Clinic automatically
            $clinic = $this->clinicRepository->create([
                'tenant_id' => tenant('id'),
                'name'      => $data['name'] . ' Clinic',
            ]);

            // 3️⃣ Create user
            $user = $this->userRepository->create([
                'tenant_id'     => tenant('id'),
                'clinic_id'     => $clinic->id,
                'name'          => $data['name'],
                'email'         => $data['email'],
                'phone'         => $data['phone'],
                'password'      => Hash::make($data['password']),
            ]);

            // 4️⃣ Create Sanctum token
            $token = $user->createToken('auth_token')->plainTextToken;

            return [
                'user'  => $user,
                'token' => $token,
            ];
        });
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

    /**
     * Forgot Password: Send OTP
     */
public function forgotPassword(string $email): array
{
    $user = $this->userRepository->findByEmail($email);

    if (!$user) {
        throw ValidationException::withMessages([
            'email' => __('auth.user_not_found'),
        ]);
    }

    // Generate 4-digit code
    $code = str_pad(random_int(0, 9999), 4, '0', STR_PAD_LEFT);

    \App\Models\VerificationCode::updateOrCreate(
        ['email' => $email],
        [
            'code' => $code,
            'expires_at' => now()->addMinutes(10),
            'created_at' => now(),
        ]
    );

    // إرسال الإيميل بالـ OTP أو تسجيله في اللوج
    // \Log::info("OTP for {$email}: {$code}");

    // 🎯 إرجاع رسالة للواجهة
    return [
        'status' => true,
        'message' => [
            'ar' => 'تم إرسال كود إلى بريدك الإلكتروني',
            'en' => 'OTP sent to your email',
        ],
    ];
}

public function verifyOtp(string $email, string $code): array
{
    $record = \App\Models\VerificationCode::where('email', $email)->first();

    if (!$record || !hash_equals($record->code, $code)) {
        // بدل ValidationException، نرجع response عادي
        return [
            'status' => false,
            'message' => [
                'ar' => 'الكود غير صحيح أو منتهي الصلاحية',
                'en' => 'Invalid or expired code.',
            ],
            'token' => null,
        ];
    }

    if ($record->expires_at->isPast()) {
        return [
            'status' => false,
            'message' => [
                'ar' => 'الكود منتهي الصلاحية',
                'en' => 'OTP has expired.',
            ],
            'token' => null,
        ];
    }

    $user = $this->userRepository->findByEmail($email);

    if (!$user) {
        return [
            'status' => false,
            'message' => [
                'ar' => 'المستخدم غير موجود',
                'en' => 'User not found.',
            ],
            'token' => null,
        ];
    }

    $token = $user->createToken('password-reset', ['access:password-reset'])->plainTextToken;

    return [
        'status' => true,
        'message' => [
            'ar' => 'تم التحقق من الكود بنجاح',
            'en' => 'OTP verified successfully',
        ],
        'token' => $token,
    ];
}


    public function resetPassword(array $input)
    {
        // 🔹 البحث عن التوكن في جدول Sanctum
        $accessToken = PersonalAccessToken::findToken($input['token']);

        if (!$accessToken || ($accessToken->expires_at && $accessToken->expires_at->isPast())) {
            return [
                'status' => false,
                'message' => 'Invalid or expired token',
            ];
        }

        // 🔹 جلب المستخدم المرتبط بالـ token
        $user = $accessToken->tokenable;

        if (!$user) {
            return [
                'status' => false,
                'message' => 'User not found',
            ];
        }

        // 🔹 تحديث الباسورد
        $user->password = Hash::make($input['password']);
        $user->save();

        // 🔹 مسح كل توكنات المستخدم بعد تغيير الباسورد
        $user->tokens()->delete();

        // 🔹 مسح كود التحقق من جدول verification_codes بعد نجاح تغيير الباسورد
        VerificationCode::where('email', $user->email)->delete();

        return [
            'status' => true,
            'message' => 'Password reset successfully',
        ];
    }






    /**
     * Resend OTP
     */
    public function resendOtp(string $email): void
    {
        // Logic similar to forgotPassword, but check time limit.
        $record = \App\Models\VerificationCode::where('email', $email)->first();

        if ($record && $record->created_at->diffInSeconds(now()) < 30) {
             throw ValidationException::withMessages([
                'code' => __('auth.throttle', ['seconds' => 30 - $record->created_at->diffInSeconds(now())]),
            ]);
        }

        $this->forgotPassword($email);
    }
}
