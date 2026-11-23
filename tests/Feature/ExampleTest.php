<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * The home route must stay registered without booting the controller.
     *
     * JackpotController's constructor talks to MySQL, Redis and a remote
     * ticker, so dispatching the request here would make a unit-level smoke
     * test depend on production infrastructure.
     */
    public function testHomeRouteIsRegistered(): void
    {
        $route = Route::getRoutes()->getByName('index');

        $this->assertNotNull($route, 'The named home route is missing.');
        $this->assertSame('/', $route->uri());
        $this->assertStringEndsWith('JackpotController@index', $route->getActionName());
    }
}
