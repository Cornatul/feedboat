<?php
declare(strict_types=1);
namespace Cornatul\Feeds\Requests;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;
use Saloon\CachePlugin\Contracts\Driver;
use Saloon\CachePlugin\Traits\HasCaching;
use Saloon\CachePlugin\Contracts\Cacheable;
use Illuminate\Support\Facades\Cache;
use Saloon\CachePlugin\Drivers\LaravelCacheDriver;
class FeedlyTopicRequest extends Request implements Cacheable
{
    use HasCaching;

    protected Method $method = Method::GET;
    public function __construct(
        protected string $topic,
    ){}


    public function resolveEndpoint(): string
    {
        return '/recommendations/topics/'  . $this->topic;
    }

    protected function defaultQuery(): array
    {
        return [
            'locale' => "en",
        ];
    }

    public function resolveCacheDriver(): Driver
    {
        return new LaravelCacheDriver(Cache::store('file'));
    }

    public function cacheExpiryInSeconds(): int
    {
        return 3600; // One Hour
    }

    protected function getCacheableMethods(): array
    {
        return [Method::GET];
    }
}
