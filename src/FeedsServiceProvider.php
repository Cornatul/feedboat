<?php

namespace Cornatul\Feeds;

use Cornatul\Feeds\Clients\FeedlyClient;
use Cornatul\Feeds\Interfaces\FeedInterface;
use Cornatul\Feeds\Services\FeedPortal;
use Cornatul\Marketing\Base\Services\Marketingportal;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class FeedsServiceProvider extends ServiceProvider
{
    final public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'feeds');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadRoutesFrom(__DIR__.'/../routes/feed.php');

        if ($this->app->runningInConsole()) {

            $this->publishes([
                __DIR__ . '/../config/config.php' => config_path('feeds.php'),
            ], 'feeds-config');

            $this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/feeds'),
            ], 'feeds-views');

            $this->publishes([
                __DIR__.'/../routes/' => \config_path('../routes/feeds'),
            ], 'feeds-routes');

            $this->publishes([
                __DIR__.'/../database/migrations/' => \config_path('../database/migrations/'),
            ], 'feeds-migrations');
        }
    }

    final public function register(): void
    {
        $this->app->bind(ClientInterface::class, Client::class);
        $this->app->bind(FeedInterface::class, FeedlyClient::class);

        $this->app->bind('feeds', static function (Application $app) {
            return $app->make(FeedPortal::class);
        });
    }

}
