<?php
declare(strict_types=1);
namespace Cornatul\Feeds\Repositories;


use Cornatul\Feeds\Models\Article;
use Cornatul\Feeds\Repositories\Interfaces\ArticleRepositoryInterface;
use Cornatul\Feeds\Repositories\Interfaces\SortableInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ArticleRepository implements ArticleRepositoryInterface, SortableInterface
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
            ->orderBy('created_at', 'DESC')
            ->limit($limit)->paginate();
    }

    public function sort(Model $model, Request $request): Model
    {
        $what = $request->get('what');
        $how = $request->get('how');
        return $model->orderBy($what, $how);
    }


}
