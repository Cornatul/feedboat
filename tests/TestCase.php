<?php

namespace Cornatul\Feeds\Tests;

use Cornatul\Feeds\FeedsServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    public function setUp(): void
    {
        parent::setUp();

    }

    final protected function getPackageProviders($app):array
    {
        $app->register(FeedsServiceProvider::class);
        return [
            FeedsServiceProvider::class
        ];
    }

    protected function getEnvironmentSetUp($app): void
    {
        // perform environment setup
    }
}
