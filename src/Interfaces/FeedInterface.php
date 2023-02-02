<?php

namespace UnixDevil\FeedBoat\Interfaces;

use UnixDevil\FeedBoat\DTO\FeedDTO;

interface FeedInterface
{
    public function find(string $topic): FeedDTO;
}
