<?php

namespace JulesGraus\Housekeeper\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use JulesGraus\Housekeeper\Providers\HousekeeperProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

abstract class TestCase extends OrchestraTestCase
{
    /**
     * Get package providers.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            HousekeeperProvider::class,
        ];
    }
}
