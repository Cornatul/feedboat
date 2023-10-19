<?php
declare(strict_types=1);
namespace Cornatul\Feeds\Contracts;

use Cornatul\Feeds\DTO\FeedDto;

interface FeedManager
{
    public function find(string $topic): FeedDto;
}
