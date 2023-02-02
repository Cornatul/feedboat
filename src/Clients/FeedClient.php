<?php

namespace UnixDevil\FeedBoat\Clients;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use JsonException;
use UnixDevil\FeedBoat\DTO\FeedDTO;
use UnixDevil\FeedBoat\Interfaces\FeedInterface;

class FeedClient implements FeedInterface
{

    private ClientInterface $client;
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    private string $source = "https://feedly.com/v3/recommendations/topics/";

    /**
     * @method find
     * @throws JsonException
     */
    public function find(string $topic, string $language = "en"): FeedDTO
    {
        $dataArray = [];
        try {
            $url = ($this->source.$topic.'?locale='.$language);

            $response = $this->client->get($url, [
                'headers' => [ 'Content-Type' => 'application/json' ]
            ]);

            $dataArray = json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);

            return FeedDTO::from($dataArray);
        } catch (GuzzleException $exception) {
            return FeedDTO::from($dataArray);
        }
    }

}
