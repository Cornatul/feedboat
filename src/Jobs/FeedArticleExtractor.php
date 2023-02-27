<?php
declare(strict_types=1);
namespace Cornatul\Feeds\Jobs;


use Carbon\Carbon;
use Cornatul\Feeds\Models\Feed;
use GuzzleHttp\ClientInterface;
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
use Throwable;
use Cornatul\Feeds\DTO\ArticleDto;

/**
 * @package UnixDevil\Crawler\Jobs
 * @class FeedCrawlerJob
 */
class FeedArticleExtractor implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private string $url;

    private Feed $feed;

    public int $tries = 1;

    public function __construct(string $url, Feed $feed)
    {
        $this->feed = $feed;
        $this->url = $url;
    }

    /**
     * @throws Throwable
     */
    final public function handle(ClientInterface $client): ArticleDto
    {
        try {

            $response = $client->post("https://v1.nlpapi.org/article", [
                'json' => [
                    'link' => $this->url
                ]
            ]);

            $collection = collect(
                json_decode(
                    $response->getBody()->getContents(),
                    false,
                    512,
                    JSON_THROW_ON_ERROR
                )
            );

            $dto = ArticleDto::from($collection->get('data'));

            dispatch(new SaveArticle($dto, $this->feed, $this->url))->onQueue('save-article');

            return $dto;

        } catch (\Exception $exception) {
            info("Something went wrong {$this->feed->url} - So we will delete this feed}");
        }



        return ArticleDto::from([]);

    }

    final public function failed($exception = null): void
    {
        $this->delete();

    }
}
