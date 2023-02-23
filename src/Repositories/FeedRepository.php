<?php

namespace Cornatul\Feeds\Repositories;

use Cornatul\Feeds\Interfaces\FeedRepositoryInterface;
use Cornatul\Feeds\Models\Feed;
use Illuminate\Pagination\LengthAwarePaginator;
class FeedRepository implements FeedRepositoryInterface
{

    final public function createFeed(array $data): bool
    {

        if ($this->imported($data['website'])) {
            return false;
        }

        $id = Feed:: create([
            'title' => $data['title'],
            'url' => $data['url'],
            'status' => 'active'
        ]);
        return (bool)$id;
    }

    final public function deleteFeed(int $id):bool
    {
        return Feed::destroy($id);
    }
    final public function findFeed(string $column, string $value): Feed
    {
        return Feed::where($column, $value)->first();
    }

    final public function imported(string $url): bool
    {
        return Feed::where('url', $url)->exists();
    }

    final public function listFeeds(int $perPage): LengthAwarePaginator
    {
        return Feed::orderBy('created_at')->paginate($perPage);
    }
}
