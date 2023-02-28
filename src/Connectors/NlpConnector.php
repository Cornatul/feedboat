<?php
declare(strict_types=1);
namespace Cornatul\Feeds\Connectors;
use Saloon\Http\Connector;
class NlpConnector extends Connector
{
    public function resolveBaseUrl(): string
    {
        return 'https://v1.nlpapi.org/';
    }

    protected function defaultHeaders(): array
    {
        return [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
    }
}
