<?php

namespace Cornatul\Feeds\Requests;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class GetArticleRequest extends Request implements HasBody
{

    use HasJsonBody;


    public function __construct(
        protected string $link,
    ){}



    public function resolveEndpoint(): string
    {
        return '/article';
    }

    protected function defaultBody(): array
    {
        return [
            'link' => $this->link,
        ];
    }
}
