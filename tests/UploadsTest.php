<?php

namespace Bakerkretzmar\LaravelMapbox\Tests;

use Mapbox;

use Bakerkretzmar\LaravelMapbox\Models\S3Credentials;

class UploadsTest extends TestCase
{
    /** @test */
    public function get_credentials()
    {
        $credentials = Mapbox::uploads()->credentials();

        $this->assertArrayHasKey('bucket', $credentials);
        $this->assertArrayHasKey('key', $credentials);
        $this->assertArrayHasKey('accessKeyId', $credentials);
        $this->assertArrayHasKey('secretAccessKey', $credentials);
        $this->assertArrayHasKey('sessionToken', $credentials);
        $this->assertArrayHasKey('url', $credentials);
    }

    /** @test */
    public function create_upload_from_url()
    {
        $dataset = Mapbox::datasets()->create();
        Mapbox::features($dataset['id'], '123')->insert(json_decode(file_get_contents(__DIR__ . '/__fixtures__/feature.json')));

        $response = Mapbox::uploads()->create([
            'tileset' => 'test_tileset_1',
            'url' => implode('/', [
                'mapbox://datasets',
                config('laravel-mapbox.username'),
                $dataset['id'],
            ]),
            'name' => 'test_tileset_1',
        ]);

        $this->assertValidUploadResponse($response);
        $this->assertEquals(config('laravel-mapbox.username'), $response['owner']);

        $this->cleanupTestDatasets([$dataset['id']]);
        Mapbox::tilesets('test_tileset_1')->delete();
    }

    /** @test */
    public function create_upload_from_dataset_id()
    {
        $dataset = Mapbox::datasets()->create();
        Mapbox::features($dataset['id'], '123')->insert(json_decode(file_get_contents(__DIR__ . '/__fixtures__/feature.json')));

        $response = Mapbox::uploads()->create([
            'tileset' => 'test_tileset_2',
            'dataset' => $dataset['id'],
            'name' => 'test_tileset_2',
        ]);

        $this->assertValidUploadResponse($response);
        $this->assertEquals(config('laravel-mapbox.username'), $response['owner']);

        $this->cleanupTestDatasets([$dataset['id']]);
        Mapbox::tilesets('test_tileset_2')->delete();
    }

    /** @test */
    public function retrieve_upload_status()
    {
        $dataset = Mapbox::datasets()->create();
        Mapbox::features($dataset['id'], '123')->insert(json_decode(file_get_contents(__DIR__ . '/__fixtures__/feature.json')));

        $upload = Mapbox::uploads()->create([
            'tileset' => 'test_tileset_3',
            'url' => implode('/', [
                'mapbox://datasets',
                config('laravel-mapbox.username'),
                $dataset['id'],
            ]),
            'name' => 'test_tileset_3',
        ]);

        $response = Mapbox::uploads($upload['id'])->get();

        $this->assertValidUploadResponse($response);

        $this->cleanupTestDatasets([$dataset['id']]);
        Mapbox::tilesets('test_tileset_3')->delete();
    }

    /** @test */
    public function list_recent_upload_statuses()
    {
        $response = Mapbox::uploads()->list();

        // @todo
        $this->assertTrue(is_array($response));
    }

    /** @test */
    public function delete_upload()
    {
        $dataset = Mapbox::datasets()->create();
        Mapbox::features($dataset['id'], '123')->insert(json_decode(file_get_contents(__DIR__ . '/__fixtures__/feature.json')));

        $upload = Mapbox::uploads()->create([
            'tileset' => 'test_tileset_4',
            'url' => implode('/', [
                'mapbox://datasets',
                config('laravel-mapbox.username'),
                $dataset['id'],
            ]),
            'name' => 'test_tileset_4',
        ]);

        while (isset($upload['complete']) && $upload['complete'] != true) {
            sleep(1);

            $upload = Mapbox::uploads($upload['id'])->get();
        }

        $response = Mapbox::uploads($upload['id'])->delete();

        $this->assertTrue($response);

        $this->cleanupTestDatasets([$dataset['id']]);
        Mapbox::tilesets('test_tileset_3')->delete();
    }
}
