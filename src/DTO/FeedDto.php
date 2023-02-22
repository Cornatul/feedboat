<?php

namespace Cornatul\Feeds\DTO;

use Illuminate\Support\Carbon;
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

    final public function getFeeds(): array
    {
        $content = collect();

        foreach ($this->feeds as $feed) {
            $prefix = 'feed/';
            $url = str_replace($prefix, '', $feed['id']);

            $data = [
                'title' => $feed['title'],
                'image' => $feed['coverUrl'] ?? null,
                'subscribers' => $feed['subscribers'],
                'description' => $feed['description'] ?? null,
                'topics' => $feed['topics'] ?? null,
                'website' => @$feed['website'] ?? null,
                'score'=> $feed['leoScore'] ?? 0,
                'updated' => Carbon::parse($feed['updated'])->format('Y-m-d H:i:s'),
                'url' => $url,
            ];



            $content->push($data);
        }

        return $content->sortBy('subscribers', $options = SORT_REGULAR, $descending = true)
            ->toArray();
    }


}
