<?php
declare(strict_types=1);
namespace Cornatul\Feeds\Interfaces;

use Cornatul\Feeds\DTO\FeedDto;

interface FeedFinderInterface
{
    public function find(string $topic): FeedDto;
}
