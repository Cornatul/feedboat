<?php
declare(strict_types=1);
namespace Cornatul\Feeds\Repositories\Contracts;

use Cornatul\Feeds\DTO\ArticleDto;
use Cornatul\Feeds\Models\Article;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

//todo refactor this to a crud interface
interface ArticleRepositoryInterface
{
    public function create(array $articleDto):bool;

    public function destroy(int $id):int;

    public function getArticlesByFeedId(int $feedId, int $limit = 10):LengthAwarePaginator;

    public function getArticleById(int $articleId):Article;

    public function update(int $id, array $data):int;

    public function getAllArticles(int $limit = 10):LengthAwarePaginator;
}
