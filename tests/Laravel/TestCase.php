<?php

declare(strict_types=1);

namespace WeForge\Tests\Laravel;

use Orchestra\Testbench\TestCase as OrchestraTestCase;

class TestCase extends OrchestraTestCase
{
    /**
     * Get package providers.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            \WeForge\WeForgeServiceProvider::class,
        ];
    }
}
