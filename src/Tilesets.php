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
    public function __construct(string $tileset_id = null)
    {
        $this->tileset_id = $tileset_id;
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
}
