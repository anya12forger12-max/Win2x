<?php

namespace Tests\Unit;

use Illuminate\Foundation\Application;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function testApplicationBoots(): void
    {
        $this->assertInstanceOf(Application::class, $this->app);
    }
}
