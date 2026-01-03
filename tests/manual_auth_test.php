<?php

require __DIR__.'/../vendor/autoload.php';

$app = require __DIR__.'/../bootstrap/app.php';

// $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
// $response = $kernel->handle(Illuminate\Http\Request::capture());

$baseUrl = 'http://127.0.0.1:8000/graphql';

function graphql($query, $variables = [], $headers = []) {
    global $baseUrl;
    $data = json_encode(['query' => $query, 'variables' => $variables]);
    
    $ch = curl_init($baseUrl);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array_merge(['Content-Type: application/json', 'Accept: application/json'], $headers));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);
    
    return json_decode($result, true);
}

// 1. Register User (to ensure we have one)
echo "1. Registering User...\n";
$email = 'test_' . time() . '@example.com';
$password = 'password123';
$mutation = '
    mutation Register($input: RegisterInput!) {
        register(input: $input) {
            status
            message
            user { id email }
            token
        }
    }
';
$vars = [
    'input' => [
        'name' => 'Test User',
        'email' => $email,
        'password' => $password,
        'password_confirmation' => $password
    ]
];

$reg = graphql($mutation, $vars);
print_r($reg);

if (!($reg['data']['register']['status'] ?? false)) {
    echo "Register failed. Continuing assuming user might exist or previous run...\n";
} else {
    echo "User registered: $email\n";
}

// 2. Forgot Password (Invalid User)
echo "\n2. Forgot Password (Invalid User)...\n";
$mutation = '
    mutation Forgot($input: ForgotPasswordInput!) {
        forgotPassword(input: $input) {
            status
            message
        }
    }
';
// Test Arabic Localization using header
$res = graphql($mutation, ['input' => ['identifier' => 'invalid@example.com']], ['language-encoding: ar']);
echo "Response (Arabic Expected): " . ($res['errors'][0]['message'] ?? 'Success?') . "\n";


// 3. Forgot Password (Valid User)
echo "\n3. Forgot Password (Valid User)...\n";
$res = graphql($mutation, ['input' => ['identifier' => $email]]);
print_r($res);


// 4. Get Code from DB (Cheat)
echo "\n4. Fetching OTP from DB using Artisan Tinker...\n";
$cmd = "php artisan tinker --execute=\"echo \App\Models\VerificationCode::where('identifier', '$email')->value('code');\"";
// Note: --execute might not be available in all versions, if not, we use pipe.
// Let's use pipe which is standard.
$cmd = "echo \App\Models\VerificationCode::where('identifier', '$email')->value('code'); | php artisan tinker";

// We need to strip the tinker banner and other output.
// Tinker usually outputs the result of the expression.
// Let's try to run it.
$output = shell_exec($cmd);

// Tinker output often contains "Psy Shell v..." and the result.
// If we just echo, the result should be on the last line or close.
// Regex to find 4 digit code.
preg_match('/(\d{4})/', $output, $matches);
$code = $matches[1] ?? null;

if (!$code) {
    echo "Could not retrieve code from Tinker output:\n$output\n";
    $code = '0000'; // Default to fail
} else {
    echo "Found Code via Tinker: $code\n";
}


// 5. Verify OTP
echo "\n5. Verify OTP...\n";
$mutation = '
    mutation Verify($input: VerifyOtpInput!) {
        verifyOtp(input: $input) {
            status
            message
            token
        }
    }
';
$res = graphql($mutation, ['input' => ['identifier' => $email, 'code' => $code]]);
print_r($res);
$resetToken = $res['data']['verifyOtp']['token'] ?? null;


if ($resetToken) {
    // 6. Reset Password
    echo "\n6. Reset Password...\n";
    $mutation = '
        mutation Reset($input: ResetPasswordInput!) {
            resetPassword(input: $input) {
                status
                message
            }
        }
    ';
    $newPassword = 'newpassword123';
    $res = graphql($mutation, ['input' => ['token' => $resetToken, 'password' => $newPassword, 'password_confirmation' => $newPassword]]);
    print_r($res);
} else {
    echo "Skipping Reset Password (No Token)\n";
}

echo "\nDone.\n";
