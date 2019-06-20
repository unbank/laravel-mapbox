<?php

namespace Bakerkretzmar\LaravelMapbox\Tests;

use Mapbox;

class DatasetsTest extends TestCase
{
    /** @test */
    public function list_datasets()
    {
        $response = Mapbox::datasets()->list();

        $this->assertValidDatasetResponse($response[0]);
    }

    /** @test */
    public function create_dataset()
    {
        $response = Mapbox::datasets()->create();

        $this->assertValidDatasetResponse($response);

        $this->cleanupTestDatasets([$response['id']]);
    }

    /** @test */
    public function create_dataset_with_metadata()
    {
        $response = Mapbox::datasets()->create([
            'name' => 'test dataset name',
            'description' => 'test dataset description',
        ]);

        $this->assertValidDatasetResponse($response);
        $this->assertEquals('test dataset name', $response['name']);
        $this->assertEquals('test dataset description', $response['description']);

        $this->cleanupTestDatasets([$response['id']]);
    }

    /** @test */
    public function retrieve_dataset()
    {
        $dataset = Mapbox::datasets()->create([]);

        $response = Mapbox::datasets($dataset['id'])->get();

        $this->assertValidDatasetResponse($response);
        $this->assertEquals($dataset['id'], $response['id']);

        $this->cleanupTestDatasets([$dataset['id']]);
    }

    /** @test */
    public function update_dataset()
    {
        $dataset = Mapbox::datasets()->create([]);

        $response = Mapbox::datasets($dataset['id'])->update([
            'name' => 'updated name',
            'description' => 'updated description',
        ]);

        $this->assertValidDatasetResponse($response);
        $this->assertEquals('updated name', $response['name']);
        $this->assertEquals('updated description', $response['description']);

        $this->cleanupTestDatasets([$dataset['id']]);
    }

    /** @test */
    public function delete_dataset()
    {
        $dataset = Mapbox::datasets()->create([]);

        $response = Mapbox::datasets($dataset['id'])->delete();

        $datasets = Mapbox::datasets()->list();

        $this->assertEquals(true, $response);
        $this->assertFalse(in_array($dataset['id'], array_column($datasets, 'id')));
    }
}
