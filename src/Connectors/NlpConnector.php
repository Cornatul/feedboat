<?php

namespace Cornatul\Feeds\Connectors;
use Saloon\Http\Connector;
class NlpConnector extends Connector
{
    public function resolveBaseUrl(): string
    {
        return 'https://v1.nlpapi.org/';
    }

    private function defaultHeaders(): array
    {
        return [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
    }
}
