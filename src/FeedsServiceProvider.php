<?php

namespace Cornatul\Feeds;

use Cornatul\Feeds\Clients\FeedlyClient;
use Cornatul\Feeds\Interfaces\FeedInterface;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Illuminate\Support\ServiceProvider;

class FeedsServiceProvider extends ServiceProvider
{
    final public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/feeds.php' => config_path('feeds.php'),
        ]);

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'feeds');
        $this->loadRoutesFrom(__DIR__.'/../routes/feeds.php');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

    }

    final public function register(): void
    {
        $this->app->bind(ClientInterface::class, Client::class);
        $this->app->bind(FeedInterface::class, FeedlyClient::class);
    }

}
