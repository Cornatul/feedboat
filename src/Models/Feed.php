<?php

namespace Cornatul\Feeds\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Builder;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

use Illuminate\Database\Query\Builder as QueryBuilder;
/**
 * @mixin    Builder
 * @mixin    QueryBuilder
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string $url
 * @property Carbon $sync
 * @property string $status
 * @method   static orderBy(string $string)
 * @method   static where(string $string, $value)
 * @method   static find($id)
 * @method   static create(array $array)
 * @method   static firstOrCreate(array $array)
 * @method   static first()
 */
class Feed extends Model
{
    use HasFactory;

    public const INITIAL =  'initial';

    public const SYNCING =  'synchronizing';

    public const COMPLETED = 'completed';

    public const FAILED = 'failed';

    protected $table = 'feeds';

    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'image',
        'score',
        'subscribers',
        'url',
        'sync'
    ];
    protected $dates = [
        'sync',
    ];

    final public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
