<?php
declare(strict_types=1);
namespace Cornatul\Feeds\Repositories;

use Cornatul\Feeds\Interfaces\ArticleRepositoryInterface;
use Cornatul\Feeds\Models\Article;

class ArticleRepository implements ArticleRepositoryInterface
{
    public function create(array $data): bool
    {
        $id =  Article::create($data);
        return (bool)$id;
    }

    public function destroy(int $id): bool
    {
        // TODO: Implement destroy() method. that actually returns a bool
        return Article::destroy($id);
    }

}
