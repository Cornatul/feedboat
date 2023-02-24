<?php

namespace Cornatul\Feeds\Repositories;

use Cornatul\Feeds\Interfaces\ArticleRepositoryInterface;
use Cornatul\Feeds\Models\Article;

class ArticleRepository implements ArticleRepositoryInterface
{
    public function create(array $data): bool
    {
        return Article::create($data);
    }

    public function destroy(int $id): bool
    {
        // TODO: Implement destroy() method.
    }

}
