<?php

namespace Cornatul\Feeds\Services;

use Cornatul\Feeds\Repositories\Interfaces\SortableInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class SortableService implements SortableInterface
{

    /**
     * @todo fix this by proper injecting something
     * @param Model $model
     * @param Request $request
     * @return mixed
     */
    public function sort($model, Request $request)
    {
        return $model->orderBy($request->get('sortWhat'), $request->get('sortHow'));
    }
}
