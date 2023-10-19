<?php
declare(strict_types=1);
namespace Cornatul\Feeds\Console;

use Cornatul\Feeds\Clients\FeedLaminasClient;
use Cornatul\Feeds\Connectors\FeedlyConnector;
use Cornatul\Feeds\Connectors\NlpConnector;
use Cornatul\Feeds\Jobs\FeedArticleExtractor;
use Cornatul\Feeds\Models\Feed;
use Cornatul\Feeds\Requests\FeedlyTopicRequest;
use Cornatul\Feeds\Requests\GetArticleRequest;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Laminas\Feed\Reader\Reader;
use Saloon\Exceptions\InvalidResponseClassException;
use Saloon\Exceptions\PendingRequestException;

class FeedEntriesExtractor extends Command
{

    protected $signature = 'feed:extract {url}';

    protected $description = 'Extract the full list of articles from a given feed';

    /**
     * @throws \ReflectionException
     * @throws InvalidResponseClassException
     * @throws PendingRequestException
     * @throws \JsonException
     */
    public function handle(): void
    {
        $url = $this->argument('url');

        $client = new FeedLaminasClient();

        Reader::setHttpClient($client);

        $data = Reader::import($url);

        $feed = Feed::first();

        foreach ($data as $entity)
        {
            dispatch(new FeedArticleExtractor($entity->getLink(), $feed))->onQueue("article-extractor");
        }

    }
}
