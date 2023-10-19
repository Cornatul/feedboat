<?php
declare(strict_types=1);
namespace Cornatul\Feeds\Jobs;


use Carbon\Carbon;
use Cornatul\Feeds\Clients\FeedLaminasClient;
use Cornatul\Feeds\Models\Feed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Bus\Batch;
use Illuminate\Bus\Queueable;

use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Laminas\Feed\Reader\Reader;
use function Laravel\Prompts\error;

/**
 * @package UnixDevil\Crawler\Jobs
 * @class FeedCrawlerJob
 */
class FeedExtractor implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Feed $feed;

    public int $tries = 1;

    public int $timeout = 360;


    public function __construct(Feed $feed)
    {
        $this->feed = $feed;
    }

    final public function handle(): void
    {
        $this->feed->sync = Feed::SYNCING;
        $this->feed->save();

        try {

            $client = new FeedLaminasClient();

            Reader::setHttpClient($client);

            $data = Reader::import($this->feed->url);



            foreach ($data as $key => $entry)
            {
                if ($entry->getDateCreated() < Carbon::now()->subDays(60)) {
                    info("Article Entry older than 60 days, skipping");
                    continue;
                }

                if (!Cache::has($entry->getLink())) {
                    Cache::put($entry->getLink(), $entry->getLink(), 60 * 60 * (24 * 30) * 30); //30 days in seconds
                    info("New entry found we should process it - {$entry->getLink()}");
                    try {

                        dispatch(new FeedArticleExtractor($entry->getLink(), $this->feed))->onQueue("article-extractor");

                    } catch (\Exception $exception) {
                        info("Something went wrong extracting the article {$entry->getLink()}}");
                        info($exception->getLine());
                        info($exception->getMessage());
                        info($exception->getTraceAsString());
                    }
                }

                info("Article Entry already processed");
            }

            $this->feed->sync = Feed::COMPLETED;
            $this->feed->save();


        }catch (\Error $exception)
        {
            info("Something went wrong {$this->feed->url}");
            info($exception->getLine());
            info($exception->getMessage());
            info($exception->getTraceAsString());
        }
    }

    final public function failed($exception = null): void
    {
        info("Failed to extract {$exception->getMessage()}");
        $this->delete();
    }

    final public function tags(): array
    {
        return [
            'feed',
            'extractor',
            'feed-extractor',
            'feed-extractor-' . $this->feed->id,
            'feed-extractor-' . $this->feed->id . '-' . $this->feed->url,
        ];
    }

    final public function completionCallback(): void
    {
        $this->feed->sync = Feed::COMPLETED;
        $this->feed->save();
    }
}
