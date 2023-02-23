<?php

namespace Cornatul\Feeds\Interfaces;

use Cornatul\Feeds\DTO\FeedDto;

interface FeedFinderInterface
{
    public function find(string $topic): FeedDto;
}
