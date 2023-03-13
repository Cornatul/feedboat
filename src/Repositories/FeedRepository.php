<?php
declare(strict_types=1);
namespace Cornatul\Feeds\Repositories;

use Cornatul\Feeds\Interfaces\FeedRepositoryInterface;
use Cornatul\Feeds\Models\Article;
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
            'user_id' => $data['user_id'] ?? 1,
            'title' => $data['title'],
            'description' => $data['description'],
            'image' => $data['image'],
            'score' => $data['score'] ?? 0,
            'subscribers' => $data['subscribers'] ?? 0,
            'url' => $data['url'],
            'sync' => Feed::INITIAL,
        ]);
        return (bool)$id;
    }

    final public function deleteFeed(int $id): int
    {
        Article::where('feed_id', $id)->delete();
        return Feed::with('articles')
            ->where('id', $id)
            ->delete();
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
        return Feed::orderBy('created_at')
            ->with('articles')
            ->paginate($perPage);
    }

    final public function getFeed(int $id): Feed
    {
        return Feed::find($id);
    }
}
