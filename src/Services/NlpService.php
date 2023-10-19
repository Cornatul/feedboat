<?php

namespace Cornatul\Feeds\Services;

use Cornatul\Feeds\Contracts\ArticleManager;
use Cornatul\Feeds\DTO\ArticleDto;
use Cornatul\Feeds\Repositories\Contracts\SortableInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class NlpService implements ArticleManager
{

    /**
     * @todo fix this by proper injecting something
     * @param Model $model
     * @param Request $request
     * @return mixed
     */
    public  function extract(string $url): \Cornatul\Feeds\DTO\ArticleDto
    {
        return new ArticleDto();
    }

}
