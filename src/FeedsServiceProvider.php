<?php
declare(strict_types=1);
namespace Cornatul\Feeds;

use Cornatul\Feeds\Clients\FeedlyClient;
use Cornatul\Feeds\Console\ArticleExtractorCommand;
use Cornatul\Feeds\Repositories\Interfaces\ArticleRepositoryInterface;
use Cornatul\Feeds\Interfaces\FeedFinderInterface;
use Cornatul\Feeds\Repositories\ArticleRepository;
use Cornatul\Feeds\Repositories\FeedRepository;
use Cornatul\Feeds\Repositories\Interfaces\FeedRepositoryInterface;
use Cornatul\Feeds\Repositories\Interfaces\SortableInterface;
use Cornatul\Feeds\Services\SortableService;
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


            $this->commands([
                ArticleExtractorCommand::class,
            ]);

        }
    }

    final public function register(): void
    {
        $this->app->bind(ClientInterface::class, Client::class);
        $this->app->bind(FeedFinderInterface::class, FeedlyClient::class);
        $this->app->bind(FeedRepositoryInterface::class, FeedRepository::class);
        $this->app->bind(ArticleRepositoryInterface::class, ArticleRepository::class);
        $this->app->bind(SortableInterface::class, SortableService::class);

    }

}
