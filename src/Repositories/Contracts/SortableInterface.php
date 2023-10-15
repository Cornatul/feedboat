<?php

namespace Cornatul\Feeds\Repositories\Contracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

interface SortableInterface
{
    /**
     * @param Model $model
     * @param Request $request
     * @return mixed
     */
    public function sort(Model $model, Request $request);

}
