<?php
declare(strict_types=1);
namespace Cornatul\Feeds\Interfaces;


use Cornatul\Feeds\DTO\FeedDto;
use Cornatul\Feeds\Models\Feed;
use Illuminate\Pagination\LengthAwarePaginator;

interface FeedRepositoryInterface
{
    public function createFeed(array $data): bool;
    public function deleteFeed(int $id): bool;
    public function imported(string $url): bool;
    public function findFeed(string $column, string $value): Feed;
    public function listFeeds(int $perPage): LengthAwarePaginator;
}
