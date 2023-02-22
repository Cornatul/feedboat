<?php

namespace Cornatul\Feeds\Interfaces;

use Cornatul\Feeds\DTO\FeedDto;

interface FeedInterface
{
    public function find(string $topic): FeedDto;
}
