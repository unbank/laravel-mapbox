<?php

namespace Bakerkretzmar\LaravelMapbox\Tests;

use Mapbox;

class FeaturesTest extends TestCase
{
    /** @test */
    public function list_features()
    {
        $dataset = Mapbox::datasets()->create();
        $feature = json_decode(file_get_contents(__DIR__ . '/__fixtures__/feature.json'));
        Mapbox::datasets($dataset['id'])->features('123')->insert($feature);

        $response = Mapbox::datasets($dataset['id'])->features()->list();

        $this->assertEquals('FeatureCollection', $response['type']);
        $this->assertValidFeatureResponse($response['features'][0]);

        $this->cleanupTestDatasets([$dataset['id']]);
    }

    /** @test */
    public function retrieve_feature()
    {
        $dataset = Mapbox::datasets()->create();
        $feature = json_decode(file_get_contents(__DIR__ . '/__fixtures__/feature.json'));
        Mapbox::datasets($dataset['id'])->features('123')->insert($feature);

        $response = Mapbox::datasets($dataset['id'])->features('123')->get();

        $this->assertValidFeatureResponse($response);

        $this->cleanupTestDatasets([$dataset['id']]);
    }

    /** @test */
    public function access_features_directly_using_shortcut()
    {
        $dataset = Mapbox::datasets()->create();
        $feature = json_decode(file_get_contents(__DIR__ . '/__fixtures__/feature.json'));
        Mapbox::features($dataset['id'], '123')->insert($feature);

        $response = Mapbox::features($dataset['id'], '123')->get();

        $this->assertValidFeatureResponse($response);

        $this->cleanupTestDatasets([$dataset['id']]);
    }

    /** @test */
    public function insert_feature()
    {
        $dataset = Mapbox::datasets()->create();
        $feature = json_decode(file_get_contents(__DIR__ . '/__fixtures__/feature.json'));

        $response = Mapbox::datasets($dataset['id'])->features('123')->insert($feature);

        $this->assertValidFeatureResponse($response);
        $this->assertEquals('123', $response['id']);
        $this->assertEquals('Feature', $response['type']);
        $this->assertEquals('Polygon', $response['geometry']['type']);

        $this->cleanupTestDatasets([$dataset['id']]);
    }

    /** @test */
    public function delete_feature()
    {
        $dataset = Mapbox::datasets()->create();
        $feature = json_decode(file_get_contents(__DIR__ . '/__fixtures__/feature.json'));
        Mapbox::datasets($dataset['id'])->features('123')->insert($feature);

        $response = Mapbox::datasets($dataset['id'])->features('123')->delete();

        $this->assertTrue($response);

        $this->cleanupTestDatasets([$dataset['id']]);
    }
}
