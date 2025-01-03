<?php

namespace Tests\Unit;

use App\Helpers\Providers;
use App\Helpers\Strings;
use App\Models\User;
use Illuminate\Foundation\Testing\Concerns\InteractsWithConsole;
use Tests\TestCase;

class HelpersTest extends TestCase
{
    use InteractsWithConsole;

    public function testCanValidateJson(): void
    {
        $this->assertTrue(Strings::jsonValidate('{"name": "Doe"}'));
    }

    public function testConfigurationCommand(): void
    {

        // $this->markTestSkipped('all tests in this file are invactive for this server configuration!');
        $this->artisan("app:set-config")
            ->expectsQuestion('What do you want to configure?', 'app_name')
            ->expectsQuestion('What do you want to set as the value for app_name?', 'Test Site')
            ->assertSuccessful();
    }

    public function testMessageParserWorks(): void
    {
        $user = User::factory()->create();

        $message = Providers::messageParser(
            "send_code::verify",
            $user,
            [
                'type' => 'email',
                'code' => '111111',
                'token' => MD5(time()),
                'label' => 'email address',
                'app_url' => config('app.frontend_url', config('app.url')),
                'app_name' => Providers::config('app_name'),
                'duration' => '10 seconds',
            ]
        );

        $this->assertCount(count($message->lines) - 1, config('messages.send_code::verify')['lines']);
    }
}