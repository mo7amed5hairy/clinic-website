<?php

namespace App\Modules\User\Services\User;

use App\Modules\User\Models\VerificationCode;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log; // For simulating email
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class ResetPasswordService
{
    /**
     * Generate code, save to DB, and send email (simulated)
     */
    public function sendCode(string $email): array
    {
        $user = User::where('email', $email)->first();

        if (!$user) {
            throw ValidationException::withMessages([
                'email' => __('passwords.user'), // Standard msg or custom
            ]);
        }

        // Generate 4 digit code
        $code = str_pad((string)rand(0, 9999), 4, '0', STR_PAD_LEFT);

        // Save to DB
        VerificationCode::create([
            'email' => $email,
            'code' => $code,
            'expires_at' => Carbon::now()->addMinute(),
        ]);

        // Simulate Sending Email
        // In real app: Mail::to($email)->send(new ResetPasswordMail($code));
        Log::info("Reset Code for {$email}: {$code}");

        return [
            'status' => true,
            'message' => 'Code sent to your email.',
        ];
    }

    /**
     * Verify code and reset password
     */
    public function reset(string $email, string $code, string $newPassword): array
    {
        // Find valid code
        $record = VerificationCode::where('email', $email)
            ->where('code', $code)
            ->first();

        if (!$record) {
            throw ValidationException::withMessages([
                'code' => 'Invalid verification code.',
            ]);
        }

        if ($record->expires_at->isPast()) {
            $record->delete(); // Cleanup
            throw ValidationException::withMessages([
                'code' => 'Verification code expired.',
            ]);
        }

        // Update Password
        $user = User::where('email', $email)->first();
        if ($user) {
            $user->password = Hash::make($newPassword);
            $user->save();
        }

        // Cleanup used code
        $record->delete();

        // Optional: Delete all other codes for this email
        VerificationCode::where('email', $email)->delete();

        return [
            'status' => true,
            'message' => 'Password reset successfully.',
        ];
    }
}
