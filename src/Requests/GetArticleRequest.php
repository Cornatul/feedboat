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
class GetArticleRequest extends Request implements HasBody
{

    use HasJsonBody;

    protected Method $method = Method::POST;
    public function __construct(
        protected string $link,
    ){}



    public function resolveEndpoint(): string
    {
        return '/article';
    }

    protected function defaultBody(): array
    {
        return [
            'link' => $this->link,
        ];
    }

}
