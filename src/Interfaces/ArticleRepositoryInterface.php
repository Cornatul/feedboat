<?php

namespace Cornatul\Feeds\Interfaces;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\View;

interface ArticleRepositoryInterface
{
    public function create(array $data):bool;

    public function destroy(int $id):int;


    public function getArticlesByFeedId(int $feedId, int $limit = 10):LengthAwarePaginator;

    public function getArticleById(int $articleId):View;
}
