<?php
declare(strict_types=1);
namespace Cornatul\Feeds\DTO;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Normalizers\ModelNormalizer;
use stdClass;

/**
 * @package Cornau\Feeds\DTO
 * @class ArticleDto
 *
 */
class ArticleDto extends Data
{
    public string $title;
    public ?string $date;
    public string $text;
    public string $html;
    public string $markdown;
    public string $banner;
    public string $summary;
    public ?array $authors;
    public ?array $keywords;
    public ?array $images;
    public ?array $entities;
    public ? StdClass $sentiment;
    public ? StdClass $social;
}
