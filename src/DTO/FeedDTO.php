<?php

namespace UnixDevil\FeedBoat\DTO;

use Spatie\LaravelData\Data;

class FeedDTO extends Data
{
    private string $title;

    private string $description;

    private string $url;

    public string $language;

    public int $size;

    #[MapInputName('feedInfos')]
    public array $feeds;
}
