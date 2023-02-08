<?php

namespace Cornatul\Feeds\DTO;

use Spatie\LaravelData\Data;

/**
 * @method static from
 */
class BaseFeedDto extends Data
{
    private string $title;

    private string $description;

    private string $url;
}
