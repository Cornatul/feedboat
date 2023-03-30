<?php
declare(strict_types=1);
namespace Cornatul\Feeds\Repositories;


use Cornatul\Feeds\Repositories\Interfaces\FeedRepositoryInterface;
use Cornatul\Feeds\Models\Article;
use Cornatul\Feeds\Models\Feed;


use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\QueryBuilder;

class FeedRepository implements FeedRepositoryInterface
{

    private string $model = Feed::class;

    private array $sorts = ['title', 'created_at', 'sync'];

    private array $filters = ['title', 'description', 'sync'];

    private int $perPage = 20;

    //todo improve this to a collection
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

    /**
     * @param string $column
     * @param string $value
     * @return Feed
     * @todo rename this and modify this to return a feed object and accept more params maybe a query object with a builder method
     */
    final public function findFeed(string $column, string $value): Feed
    {
        return Feed::where($column, $value)->first();
    }

    final public function imported(string $url): bool
    {
        return Feed::where('url', $url)->exists();
    }

    final public function listFeeds(): LengthAwarePaginator
    {
        //@todo refactor this to accept a request and push to a pipeline that will use the query builder to build the query

        return QueryBuilder::for($this->model)
            ->allowedIncludes(['articles'])
            ->allowedSorts($this->sorts)
            ->allowedFilters($this->filters)
            ->paginate($this->perPage)->appends(request()->query());
    }

    final public function getFeed(int $id): Feed
    {
        return Feed::find($id);
    }


}
