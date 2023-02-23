<?php
namespace Cornatul\Feeds\Jobs;


use Carbon\Carbon;
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
use Vedmant\FeedReader\Facades\FeedReader;

/**
 * @package UnixDevil\Crawler\Jobs
 * @class FeedCrawlerJob
 */
class FeedExtractor implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Feed $feed;

    public int $tries = 1;

    public function __construct(Feed $feed)
    {
        $this->feed = $feed;
    }

    /**
     * @throws Throwable
     */
    final public function handle(): void
    {
        try {

            $data = Reader::import($this->feed->url);

            foreach ($data as $key => $entry) {
                if ($entry->getDateCreated() < Carbon::now()->subDays(30)) {
                    info("Entry older than 30 days, skipping");
                    continue;
                }

                if (!Cache::has($entry->getLink())) {
                    Cache::put($entry->getLink(), $entry->getLink(), 60 * 60 * (24 * 30) * 30); //30 days in seconds
                    info("New entry found we should process it - {$entry->getLink()}");
                    dispatch(new FeedArticleExtractor($entry->getLink(), $this->feed))->onQueue("article-extractor");

                } else {
                    info("Entry already processed");
                }
            }
        } catch (\Exception $exception) {
            info("Something went wrong {$this->feed->url} - So we will delete this feed}");
            $this->feed->delete();
        }
    }

    final public function failed($exception = null): void
    {
        $this->delete();

        $this->feed->delete();
    }
}
