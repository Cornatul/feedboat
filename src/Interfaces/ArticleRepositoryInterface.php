<?php

namespace Cornatul\Feeds\Interfaces;

interface ArticleRepositoryInterface
{
    public function create(array $data):bool;

    public function destroy(int $id):bool;
}
