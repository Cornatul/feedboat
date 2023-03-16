<?php
declare(strict_types=1);
namespace Cornatul\Feeds\Repositories\Interfaces;


use Cornatul\Feeds\DTO\FeedDto;
use Cornatul\Feeds\Models\Feed;
use Illuminate\Pagination\LengthAwarePaginator;
//todo refactor this to to be a interface that includes multiple interfaces and dump the di into the container
interface FeedRepositoryInterface
{
    public function createFeed(array $data): bool;
    public function deleteFeed(int $id): int;
    public function imported(string $url): bool;
    public function findFeed(string $column, string $value): Feed;
    public function listFeeds():  \Illuminate\Contracts\Pagination\LengthAwarePaginator;
    public function getFeed(int $id): Feed;
}
