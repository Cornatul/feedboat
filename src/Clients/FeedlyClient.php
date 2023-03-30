<?php
declare(strict_types=1);
namespace Cornatul\Feeds\Clients;

use Cornatul\Feeds\Connectors\FeedlyConnector;
use Cornatul\Feeds\Interfaces\FeedFinderInterface;
use Cornatul\Feeds\Requests\FeedlyTopicRequest;



use Cornatul\Feeds\DTO\FeedDto;
use ReflectionException;
use Saloon\Exceptions\InvalidResponseClassException;
use Saloon\Exceptions\PendingRequestException;


class FeedlyClient implements FeedFinderInterface
{
    /**
     * @method find
     */
    public function find(string $topic, string $language = "en"): FeedDTO
    {

        //@todo refactor this to a service that will accept a connect and a request and return a dto
        $dataArray = [];

        try {

            $feedlyConnector = new FeedlyConnector();

            $response = $feedlyConnector->send(new FeedlyTopicRequest($topic));

            return FeedDto::from($response->json());

        } catch (ReflectionException|InvalidResponseClassException|PendingRequestException $exception) {
            //@todo log this exception

            logger($exception->getMessage());
        }

        return FeedDto::from($dataArray);

    }

}
