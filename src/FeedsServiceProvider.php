<?php
declare(strict_types=1);
namespace Cornatul\Feeds;

use Cornatul\Feeds\Clients\FeedlyClient;
use Cornatul\Feeds\Console\ArticleExtractorCommand;
use Cornatul\Feeds\Contracts\FeedManager;
use Cornatul\Feeds\Repositories\Contracts\ArticleRepositoryInterface;
use Cornatul\Feeds\Contracts\FeedFinderInterface;
use Cornatul\Feeds\Repositories\ArticleEloquentRepository;
use Cornatul\Feeds\Repositories\FeedRepository;
use Cornatul\Feeds\Repositories\Contracts\FeedRepositoryInterface;
use Cornatul\Feeds\Repositories\Contracts\SortableInterface;
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
        //todo move this to a system server manager class  and use a system provider for every social provider
        //@todo -> The provider should be able to register the social client and return a social client instance response that contais the feed dto , this can be a any response from rss clients which are contained into a docker server that is running on the system gateway.
        $this->app->bind(FeedManager::class, FeedlyClient::class);




        $this->app->bind(FeedRepositoryInterface::class, FeedRepository::class);
        $this->app->bind(ArticleRepositoryInterface::class, ArticleEloquentRepository::class);
        $this->app->bind(SortableInterface::class, SortableService::class);

    }

}
