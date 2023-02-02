<?php

namespace UnixDevil\FeedBoat\Tests;

use UnixDevil\FeedBoat\Providers\FeedBoatProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    public function setUp(): void
    {
        parent::setUp();

    }

    final protected function getPackageProviders($app):array
    {
        $app->register(FeedBoatProvider::class);
        return [
            FeedBoatProvider::class
        ];
    }

    protected function getEnvironmentSetUp($app): void
    {
        // perform environment setup
    }
}
