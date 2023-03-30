<?php
declare(strict_types=1);
namespace Cornatul\Feeds\Repositories\Interfaces;


use Cornatul\Feeds\Models\Feed;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

//todo refactor this to to be a interface that includes multiple interfaces and dump the di into the container
interface FeedRepositoryInterface
{
    public function createFeed(array $data): bool;
    public function deleteFeed(int $id): int;
    public function imported(string $url): bool;
    public function findFeed(string $column, string $value): Feed;

    //todo refactor this to accept a request and push to a pipeline that will use the query builder to build the query
    public function listFeeds():  LengthAwarePaginator;
    public function getFeed(int $id): Feed;
}
