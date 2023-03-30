<?php
declare(strict_types=1);
namespace Cornatul\Feeds\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Article
 * @param string source
 * @param string title
 * @param string date
 * @param string text
 * @param string html
 * @param string markdown
 * @method static create(array $postData)
 * @method static where(string $column, int $value)
 * @method static destroy(int $id)
 * @method static update(array $data)
 * @method static first()
 * @method static orderBy(string $column, string $direction)
 *
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
        "social",
        "sentiment",
    ];

    protected $casts = [
        'sentiment' => 'json',
        'pos' => 'float',
        'neu' => 'float',
        'neg' => 'float',
        'compound' => 'float',
    ];

    public function feed():BelongsTo
    {
        return $this->belongsTo(Feed::class);
    }
}
