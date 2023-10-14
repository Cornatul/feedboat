<?php
declare(strict_types=1);
namespace Cornatul\Feeds\Clients;

use Cornatul\Feeds\Connectors\FeedlyConnector;
use Cornatul\Feeds\Contracts\FeedManager;
use Cornatul\Feeds\Contracts\FeedFinderInterface;
use Cornatul\Feeds\Requests\FeedlyTopicRequest;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use JsonException;
use Cornatul\Feeds\DTO\FeedDto;
use Saloon\Exceptions\InvalidResponseClassException;
use Saloon\Exceptions\PendingRequestException;


class FeedlyClient implements FeedManager
{
    /**
     * @method find
     */
    public final function find(string $topic, string $language = "en"): FeedDTO
    {

        try {

            $feedlyConnector = new FeedlyConnector();

            $response = $feedlyConnector->send(new FeedlyTopicRequest($topic));

            return FeedDto::from($response->json());

        } catch (GuzzleException|\ReflectionException|InvalidResponseClassException|PendingRequestException $exception) {

            logger($exception->getMessage());
        }

        return FeedDto::from([]);

    }

}
