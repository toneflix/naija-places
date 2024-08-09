<?php

namespace Tests\Feature;

use App\Helpers\Url;
use App\Models\PasswordCodeResets;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PasswordTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->markTestSkipped('all tests in this file are invactive for this server configuration!');
    }

    public function testCanRequestPasswordReset(): void
    {
        $user = User::factory()->unverified()->create();

        $response = $this->post(
            'api/auth/forgot-password',
            ['email' => $user->email]
        );

        $response->assertCreated();
    }

    public function testCanCheckPasswordResetCode(): void
    {
        $user = User::factory()->unverified()->create();

        $this->post(
            'api/auth/forgot-password',
            ['email' => $user->email]
        );

        $code = PasswordCodeResets::latest()->firstWhere('email', $user->email);

        $response = $this->post(
            'api/auth/reset-password/check-code',
            ['code' => $code->code]
        );

        $response->assertAccepted();
    }

    public function testCanResetPassword(): void
    {
        $user = User::factory()->unverified()->create();

        $this->post(
            'api/auth/forgot-password',
            ['email' => $user->email]
        );

        $code = PasswordCodeResets::latest()->firstWhere('email', $user->email);

        $response = $this->post(
            'api/auth/reset-password/check-code',
            [
                'code' => $code->code,
                'password' => 'password',
                'password_confirmation' => 'password',
            ]
        );

        $response->assertAccepted();
    }

    public function testCanResetPasswordWithToken(): void
    {
        $user = User::factory()->unverified()->create();

        $this->post(
            'api/auth/forgot-password',
            ['email' => $user->email]
        );

        $code = PasswordCodeResets::latest()->firstWhere('email', $user->email);

        $response = $this->post(
            'api/auth/reset-password/check-code',
            [
                'code' => Url::base64urlEncode($code->code . '|' . MD5(time())),
                'password' => 'password',
                'password_confirmation' => 'password',
            ]
        );

        $response->assertAccepted();
    }
}
