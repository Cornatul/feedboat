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
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use JsonException;
use Cornatul\Feeds\DTO\FeedDto;
use Saloon\Exceptions\InvalidResponseClassException;
use Saloon\Exceptions\PendingRequestException;
use Spatie\SchemaOrg\Contracts\ArticleContract;


class NLPClient implements ArticleManager
{
    /**
     * @method find
     */
    public final function find(string $url, string $language = "en"): ArticleDto
    {

        try {

            $nlpConnector = new NlpConnector();

            $response = $nlpConnector->send(new GetArticleRequest($topic));

            return ArticleDto::from($response->json());

        } catch (GuzzleException|\ReflectionException|InvalidResponseClassException|PendingRequestException $exception) {

            logger($exception->getMessage());
        }

        return ArticleDto::from([]);

    }

}
