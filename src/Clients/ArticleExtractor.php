<?php

namespace Cornatul\Feeds\Clients;

use Cornatul\Feeds\DTO\ArticleDto;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Config;
use JsonException;


/**
 * @todo find an way to implement a client here
 * @class NLPClient
 */
class ArticleExtractor
{

    private string $sentimentEndpoint;

    private ClientInterface $client;

    public function __construct(ClientInterface $client, string $sentimentEndpoint = "")
    {
        $this->client = $client;
        $this->sentimentEndpoint = $sentimentEndpoint;
    }


    /**
     * @throws GuzzleException
     * @throws JsonException
     */
    final public function getArticleSentiment(string $urlToExtract): ArticleDto
    {
        //
        $response = $this->client->post($this->sentimentEndpoint, [
            'json' => [
                'link' => $urlToExtract
            ]
        ]);

        $collection = collect(
            json_decode(
                $response->getBody()->getContents(),
                false,
                512,
                JSON_THROW_ON_ERROR
            )
        );

        return ArticleDto::from($collection->get('data'));
    }
}
