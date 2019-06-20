<?php

namespace Bakerkretzmar\LaravelMapbox;

use Bakerkretzmar\LaravelMapbox\Models\S3Credentials;

use RunTimeException;

use Zttp\Zttp;
use Zttp\ZttpResponse;

class Mapbox
{
    /**
     * Mapbox API endpoint names and status codes.
     */
    const DATASETS_ENDPOINT = 'datasets';
    const TILESETS_ENDPOINT = 'tilesets';
    const FEATURES_ENDPOINT = 'features';
    const UPLOADS_ENDPOINT = 'uploads';
    const DELETE_SUCCESS_STATUS = 204;

    protected $config;

    /**
     * Create a new instance of the Mapbox API wrapper.
     *
     * @param  array  $config
     */
    public function __construct(array $config = [])
    {
        $this->config = $config;
    }

    /**
     * Create a new Datasets request.
     *
     * @param   string|null  $dataset_id
     * @return  Datasets
     */
    public function datasets(string $dataset_id = null)
    {
        return new Datasets($dataset_id);
    }

    /**
     * Shortcut to create a new Features request for a given Dataset.
     *
     * @param   string       $dataset_id
     * @param   string|null  $feature_id
     * @return  Features
     */
    public function features(string $dataset_id, string $feature_id = null)
    {
        if (! $dataset_id) {
            throw new RunTimeException('Dataset ID required');
        }

        return new Features($dataset_id, $feature_id);
    }

    /**
     * Create a new Tilesets request.
     *
     * @param   string|null  $tileset_id
     * @return  Tilesets
     */
    public function tilesets(string $tileset_id = null)
    {
        return new Tilesets($tileset_id);
    }

    /**
     * Set API to work with Uploads
     * @param  string $id    Optional
     * @return Mapbox Class
     */
    public function uploads($id = null)
    {
        $this->currentType = Mapbox::UPLOAD;
        $this->dataset_id = $id;

        return $this;
    }

    // public function list($options = [])
    // {
    //     if (count($options) && $this->currentType == Mapbox::DATASET)
    //     {
    //         throw new RunTimeException('Dataset listing does not support parameters');
    //     }

    //     $response = Zttp::get($this->getUrl($this->currentType), $options);

    //     return $response->json();
    // }

    // public function create(array $data = [])
    // {
    //     $response = Zttp::post($this->getUrl($this->currentType), $data);

    //     return $response->json();
    // }

    // public function get()
    // {
    //     if ($this->dataset_id == null)
    //     {
    //         throw new RunTimeException('Dataset ID Required');
    //     }

    //     $response = Zttp::get($this->getUrl($this->currentType, $this->dataset_id));

    //     return $response->json();
    // }

    // public function update($data)
    // {
    //     if ($this->dataset_id == null)
    //     {
    //         throw new RunTimeException('Dataset ID Required');
    //     }

    //     $response = Zttp::patch($this->getUrl($this->currentType, $this->dataset_id), $data);

    //     return $response->json();
    // }

    // public function delete()
    // {
    //     if (! $this->dataset_id) {
    //         throw new RunTimeException('Dataset ID required');
    //     }

    //     return Zttp::delete($this->getUrl($this->currentType, $this->dataset_id));
    // }

    // public function features($feature_id = null)
    // {
    //     if ($this->currentType !== Mapbox::DATASET)
    //     {
    //         throw new RunTimeException('Features only work with Datasets');
    //     }

    //     if (! $this->dataset_id) {
    //         throw new RunTimeException('Dataset ID required');
    //     }

    //     return new Features($this->dataset_id, $feature_id);
    // }

    /**
     * Get Temporary S3 Credentials (UPLOADS ONLY)
     */
    public function credentials()
    {
        if ($this->currentType !== Mapbox::UPLOAD)
        {
            throw new RunTimeException('Credentials only work with Uploads');
        }

        $response = Zttp::get($this->getUrl($this->currentType, null, ['credentials']));

        return new S3Credentials($response->json());
    }
}
