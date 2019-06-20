<?php

namespace Bakerkretzmar\LaravelMapbox;

use RunTimeException;

use Zttp\Zttp;

class Tilesets extends MapboxRequest
{
    /**
     * Create a new Tileset request instance.
     *
     * @param  string|null  $tileset_id
     */
    public function __construct(string $tileset = null)
    {
        $this->tileset = $tileset;
    }

    /**
     * List Tilesets.
     *
     * @see     https://docs.mapbox.com/api/maps/#list-tilesets
     * @return  array
     */
    public function list()
    {
        return Zttp::get($this->url(Mapbox::TILESETS_ENDPOINT))->json();
    }

    /**
     * Delete a Tileset.
     *
     * @see     https://docs.mapbox.com/api/maps/#delete-tileset
     * @return  bool
     */
    public function delete()
    {
        if (! $this->tileset) {
            throw new RunTimeException('Tileset name required');
        }

        return Zttp::delete($this->url(Mapbox::TILESETS_ENDPOINT, config('laravel-mapbox.username') . '.' . $this->tileset))->status() === Mapbox::DELETE_SUCCESS_STATUS;
    }
}
