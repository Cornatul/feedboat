<?php
declare(strict_types=1);
namespace Cornatul\Feeds\Connectors;
use League\Flysystem\Config;
use Saloon\Http\Connector;
class NlpConnector extends Connector
{
    public function resolveBaseUrl(): string
    {
        return Config::get('feeds.nlp-api-url');
    }

    protected function defaultHeaders(): array
    {
        return [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
    }
}
