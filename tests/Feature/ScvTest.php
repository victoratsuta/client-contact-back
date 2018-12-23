<?php

namespace Tests\Feature;

use App\Models\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;

class ScvTest extends TestCase
{
    use WithoutMiddleware;

    const FILE = 'tests/fixtures/clients.csv';
    const FILE_UPDATE = 'tests/fixtures/clients_updated.csv';

    public function testUpload()
    {
        Client::query()->delete();

        $file = $this->getUploadableFile(base_path(self::FILE));
        $fileData = array_map('str_getcsv', file(base_path(self::FILE)));

        $registerData = $this->login();

        $response = $this
            ->withHeaders(
                [
                    'Authorization' => 'Bearer ' . $registerData->auth_token
                ]
            )
            ->json('POST', 'api/scv',
                [
                    'csv' => $fileData
                ])
            ->assertStatus(200);


        $countInFile = count($fileData);

        $oldCount = Client::all()->count();

        $this->assertTrue($oldCount <= $countInFile);

        $file = $this->getUploadableFile(base_path(self::FILE_UPDATE));
        $fileData = array_map('str_getcsv', file(base_path(self::FILE)));

        $response = $this
            ->withHeaders(
                [
                    'Authorization' => 'Bearer ' . $registerData->auth_token
                ]
            )
            ->json('POST', 'api/scv',
                [
                    'csv' => $fileData
                ])
            ->assertStatus(200);


        $this->assertEquals($oldCount, Client::all()->count());

    }

    protected function getUploadableFile($file)
    {
        $dummy = file_get_contents($file);
        file_put_contents(base_path("tests/" . basename($file)), $dummy);
        $path = base_path("tests/" . basename($file));
        $original_name = 'subscribers.csv';
        $mime_type = 'text/csv';
        $size = 111;
        $error = null;
        $test = true;
        $file = new UploadedFile($path, $original_name, $mime_type, $size, $error, $test);
        return $file;
    }
}
