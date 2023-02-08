<?php

namespace Cornatul\Feeds\Interfaces;

use Cornatul\Feeds\DTO\FeedDto;

interface FeedInterface
{
    //todo change tis to return a base dto
    public function find(string $topic): FeedDto;
}
