<?php

namespace Tests\Feature;

use App\Events\Verified;
use App\Helpers\Url;
use App\Models\User;
use App\Notifications\AccountVerified;
use App\Notifications\SendCode;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class NotificationsTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // $this->markTestSkipped('all tests in this file are invactive for this server configuration!');
    }

    /**
     * A basic feature test example.
     */
    public function testCanSendVerificationCode(): void
    {
        Notification::fake();

        $user = User::factory()->create();

        $user->sendEmailVerificationNotification();

        Notification::assertSentTo(
            $user,
            function (SendCode $notification, array $channels) use ($user) {
                return $notification->code === $user->email_verify_code;
            }
        );
    }

    public function testCanSendVerifiedNotification(): void
    {
        Notification::fake();

        $user = User::factory()->unverified()->create();

        $user->sendEmailVerificationNotification();

        $this->actingAs($user)->put(
            'api/v1/verify/with-code/email',
            ['code' => $user->email_verify_code]
        );

        Notification::assertSentTo(
            $user,
            AccountVerified::class
        );
    }

    public function testDispatchesVerifiedEvent(): void
    {
        Event::fake();

        $user = User::factory()->unverified()->create();

        $user->sendEmailVerificationNotification();

        $this->actingAs($user)->put(
            'api/v1/verify/with-code/email',
            ['code' => $user->email_verify_code]
        );

        Event::assertDispatched(function (Verified $event) use ($user) {
            return $event->user->is($user);
        });
    }

    public function testDispatchesVerifiedEventFromToken(): void
    {
        Event::fake();

        $user = User::factory()->unverified()->create();

        $user->sendEmailVerificationNotification();

        $this->actingAs($user)->put(
            'api/v1/verify/with-code/email',
            ['code' => Url::base64urlEncode($user->email_verify_code . '|' . MD5(time()))]
        );

        Event::assertDispatched(function (Verified $event) use ($user) {
            return $event->user->is($user);
        });
    }
}