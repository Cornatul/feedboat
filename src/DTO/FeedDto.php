<?php

namespace Cornatul\Feeds\DTO;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;

/**
 * @method static from
 */
class FeedDto extends BaseFeedDto
{

    public string $language;

    public int $size;

    #[MapInputName('feedInfos')]
    public array $feeds;

    public function getFeeds(): array
    {
        $content = collect([]);

        foreach ($this->feeds as $feed) {
            $prefix = 'feed/';
            $url = $feed['feedId'];
            if (str_starts_with($url, $prefix)) {
                $url= substr($url, strlen($prefix));
            }

            $data = [
                'title' => $feed['title'],
                'image' => @$feed['coverUrl'],
                'subscribers' => $feed['subscribers'],
                'description' => @$feed['description'],
                'topics' => @$feed['topics'],
                'website' => @$feed['website'],
                'score'=> $feed['leoScore'] ?? 0,
                'last_update' => gmdate('Y-m-d', $feed['updated']),
                'updated' => $feed['updated'],
                'url' => $url,
            ];

            $data["exists"] = false;

            $content->push($data);
        }

        $content->sortBy('subscribers', $options = SORT_REGULAR, $descending = true);

        return $content->toArray();
    }
}
