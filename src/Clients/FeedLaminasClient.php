<?php
declare(strict_types=1);
namespace Cornatul\Feeds\Clients;

use Cornatul\Feeds\Connectors\FeedlyConnector;
use Cornatul\Feeds\Connectors\NlpConnector;
use Cornatul\Feeds\Contracts\ArticleManager;
use Cornatul\Feeds\Contracts\FeedManager;
use Cornatul\Feeds\Contracts\FeedFinderInterface;
use Cornatul\Feeds\DTO\ArticleDto;
use Cornatul\Feeds\Requests\FeedlyTopicRequest;
use Cornatul\Feeds\Requests\GetArticleRequest;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use JsonException;
use Cornatul\Feeds\DTO\FeedDto;
use Saloon\Exceptions\InvalidResponseClassException;
use Saloon\Exceptions\PendingRequestException;
use Spatie\SchemaOrg\Contracts\ArticleContract;


class FeedLaminasClient implements \Laminas\Feed\Reader\Http\ClientInterface
{

    private int $statusCode = 200;

    private string $body = '';

    /**
     * @method get
     * @throws GuzzleException
     */
    public final function get($url)
    {
        $client = new Client();

        $response =  $client->get($url);

        $this->body = $response->getBody()->getContents();

        $this->statusCode = $response->getStatusCode();

        return $this;
    }

    public final function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public final function getBody(): string
    {
        return $this->body;
    }
}
