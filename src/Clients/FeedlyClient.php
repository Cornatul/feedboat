<?php

namespace Cornatul\Feeds\Clients;

use Cornatul\Feeds\Connectors\FeedlyConnector;
use Cornatul\Feeds\Interfaces\FeedFinderInterface;
use Cornatul\Feeds\Requests\FeedlyTopicRequest;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use JsonException;
use Cornatul\Feeds\DTO\FeedDto;
use Saloon\Exceptions\InvalidResponseClassException;
use Saloon\Exceptions\PendingRequestException;


class FeedlyClient implements FeedFinderInterface
{
    /**
     * @method find
     */
    public function find(string $topic, string $language = "en"): FeedDTO
    {
        $dataArray = [];

        try {

            $feedlyConnector = new FeedlyConnector();

            $response = $feedlyConnector->send(new FeedlyTopicRequest($topic));

            return FeedDto::from($response->json());

        } catch (GuzzleException|\ReflectionException|InvalidResponseClassException|PendingRequestException $exception) {

            logger($exception->getMessage());
        }

        return FeedDto::from($dataArray);

    }

}
