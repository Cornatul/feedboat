<?php

namespace Cornatul\Feeds\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Article
 * @method static create(array $postData)
 */
class Article extends Model
{
    protected $table = 'feeds_article';

    public $fillable = [
        'feed_id',
        'source',
        'title' ,
        'date' ,
        'text',
        'html',
        'markdown',
        'banner',
        'summary',
        "authors",
        "keywords",
        "images",
        "entities",
    ];
}
