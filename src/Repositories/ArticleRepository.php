<?php
declare(strict_types=1);
namespace Cornatul\Feeds\Repositories;

use Cornatul\Feeds\Repositories\Interfaces\SortArticlesInterface;
use Cornatul\Feeds\Respositories\Interfaces\ArticleRepositoryInterface;
use Cornatul\Feeds\Models\Article;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;

class ArticleRepository implements ArticleRepositoryInterface, SortArticlesInterface
{
    public function create(array $data): bool
    {
        $id =  Article::create($data);
        return (bool)$id;
    }

    public function destroy(int $id): int
    {
        return Article::destroy($id);
    }

    public function getArticlesByFeedId(int $feedId, int $limit = 10): LengthAwarePaginator
    {
        return Article::where('feed_id', $feedId)->limit($limit)->paginate();
    }

    public function getArticleById(int $articleId): Article
    {
        return Article::where('id', $articleId)->first();
    }


    public function update(int $id, array $data): int
    {
        return Article::where('id', $id)->update($data);
    }

    public function getAllArticles(int $limit = 10): LengthAwarePaginator
    {
        return Article::with('feed')
            ->orderByRaw("JSON_EXTRACT(sentiment, '$.pos') DESC")
            ->limit($limit)->paginate();
    }

    public function sort(Model $mode, string $what, string $how)
    {
        return $mode->orderBy($what, $how);
    }

}
