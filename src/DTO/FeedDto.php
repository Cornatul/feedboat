<?php
declare(strict_types=1);
namespace Cornatul\Feeds\DTO;

use Cornatul\Feeds\Models\Feed;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;

/**
 * @method static from
 */
class FeedDto extends Data
{
    public string $language;

    public int $size;

    #[MapInputName('relatedTopics')]
    public array $topics;

    #[MapInputName('feedInfos')]
    public array $feeds;

    public string $updated;

    public string $visual;

    //move this logic to a transformer
    final public function getFeeds(): Collection
    {
        $content = collect();

        foreach ($this->feeds as $feed) {
            $prefix = 'feed/';
            $url = str_replace($prefix, '', $feed['id']);

            $data = [
                'id' => $feed['id'] ?? null,
                'feedId' => $feed['feedId'] ?? null,
                'title' => $feed['title'] ?? null,
                'image' => $feed['coverUrl'] ?? null,
                'subscribers' => $feed['subscribers'] ?? 0,
                'description' => $feed['description'] ?? null,
                'topics' => $feed['topics'] ?? null,
                "iconUrl" => $feed['iconUrl'] ?? null,
                "coverUrl" => $feed['coverUrl'] ?? null,
                "visualUrl" => $feed['visualUrl'] ?? null,
                'website' => $feed['website'] ?? null,
                'score'=> $feed['leoScore'] ?? 0,
                "imported" => $this->checkImported($url),
                'updated' => Carbon::parse($feed['updated'])->format('Y-m-d H:i:s'),
                'url' => $url,
            ];

            $content->push($data);
        }

        return $content->sortBy('subscribers', $options = SORT_REGULAR, $descending = true);
    }

    private function checkImported(string $url): bool
    {
        return Feed::where('url', $url)->exists();
    }

}
