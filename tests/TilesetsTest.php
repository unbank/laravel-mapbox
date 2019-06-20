<?php

namespace Bakerkretzmar\LaravelMapbox\Tests;

use Mapbox;

class TilesetsTest extends TestCase
{
    /** @test */
    public function list_tilesets()
    {
        $response = Mapbox::tilesets()->list();

        $this->assertTrue(is_array($response));
        // @todo
        // $this->assertValidTilesetResponse($response);
    }
}
