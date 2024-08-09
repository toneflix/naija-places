<?php

namespace Tests\Feature;

use App\Models\Configuration;
use App\Models\File;
use Database\Seeders\ConfigurationSeeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class FileTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->markTestSkipped('all tests in this file are invactive for this server configuration!');
    }

    public function testFileUpload(): void
    {
        Route::post('/test/file/upload', function (Request $request) {
            $file = File::make();
            $file->meta = ['test' => '/test/file/upload'];
            $file->file = $request->file('file');
            $file->save();
        });

        $file = UploadedFile::fake()->image('avatar.jpg');
        $this->post('/test/file/upload', [
            'file' => $file
        ]);
        $this->assertTrue(File::whereJsonContains('meta->test', '/test/file/upload')->exists());
    }

    public function testCreateConfigurationWithFileValue(): void
    {
        $time = (string)time();
        Route::post('/test/file/config/upload', function (Request $request) use ($time) {
            $conf = Configuration::factory()->create(
                [
                    'key' => "test_banner_$time",
                    'title' => 'Test Banner',
                    'value' => $time,
                    'type' => 'file',
                    'autogrow' => false,
                    'secret' => false,
                    "autogrow" => true
                ]
            );

            $conf->value = $request->file('file');
            $conf->save();
        });

        $file = UploadedFile::fake()->image('avatar.jpg');
        $this->post('/test/file/config/upload', [
            'file' => $file
        ]);

        $conf = Configuration::where("key", "test_banner_$time")->first();
        $this->assertStringContainsString('.jpg', $conf->value);
    }

    public function testCreateConfigurationWithMultipleFilesValue(): void
    {
        $time = (string)time();
        Route::post('/test/file/config/upload', function (Request $request) use ($time) {
            $conf = Configuration::factory()->create(
                [
                    'key' => "test_multiple_banners_$time",
                    'title' => 'Test Banner',
                    'value' => $time,
                    'type' => 'files',
                    'autogrow' => false,
                    'secret' => false,
                    "autogrow" => true
                ]
            );

            $conf->value = $request->file('file');
            $conf->save();
        });

        $files = [
            UploadedFile::fake()->image('avatar1.jpg'),
            UploadedFile::fake()->image('avatar2.jpg')
        ];
        $this->post('/test/file/config/upload', [
            'file' => $files
        ]);

        $conf = Configuration::where("key", "test_multiple_banners_$time")->first();
        $this->assertStringContainsString('.jpg', $conf->value->pluck('file_url')->first());
        $this->assertStringContainsString('.jpg', $conf->value->pluck('file_url')->last());
    }
}
