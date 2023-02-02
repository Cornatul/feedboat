<?php

namespace UnixDevil\FeedBoat\Providers;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Illuminate\Support\ServiceProvider;
use UnixDevil\Crawler\Contracts\SentimentContract;
use UnixDevil\CrawlerBoat\Client\SentimentClient;
use UnixDevil\CrawlerBoat\Interfaces\CrawlerConfigInterface;
use UnixDevil\CrawlerBoat\Services\CrawlerConfigService;

class FeedBoatProvider extends ServiceProvider
{
    final public function boot(): void
    {
    }

    final public function register(): void
    {
        $this->app->bind(ClientInterface::class, Client::class);
    }

}
