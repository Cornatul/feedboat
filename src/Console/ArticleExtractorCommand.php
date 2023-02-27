<?php
declare(strict_types=1);
namespace Cornatul\Feeds\Console;

use Cornatul\Feeds\Connectors\FeedlyConnector;
use Cornatul\Feeds\Connectors\NlpConnector;
use Cornatul\Feeds\Requests\FeedlyTopicRequest;
use Cornatul\Feeds\Requests\GetArticleRequest;
use Illuminate\Console\Command;
use Saloon\Exceptions\InvalidResponseClassException;
use Saloon\Exceptions\PendingRequestException;

class ArticleExtractorCommand extends Command
{

    protected $signature = 'article:extract {url}';

    protected $description = 'Extract the full article from a given url';

    /**
     * @throws \ReflectionException
     * @throws InvalidResponseClassException
     * @throws PendingRequestException
     * @throws \JsonException
     */
    public function handle(): void
    {
        $this->getTopicsFeeds();
    }


    /**
     * @throws InvalidResponseClassException
     * @throws \ReflectionException
     * @throws PendingRequestException
     * @throws \JsonException
     */
    private function getTopicsFeeds()
    {
        $this->info('Welcome to the feeds:sentiment command');
        $url = $this->argument('url');

        $feedlyConnector = new FeedlyConnector();
        $dataSc = $feedlyConnector->send(new FeedlyTopicRequest('laravel'));
        $this->info(json_encode($dataSc, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT));
    }


    /**
     * @throws InvalidResponseClassException
     * @throws \ReflectionException
     * @throws PendingRequestException
     * @throws \JsonException
     */
    private function getArticle()
    {
        $this->info('Welcome to the feeds:sentiment command');
        $url = $this->argument('url');
        $connector = new NlpConnector();

        $response = $connector->send(new GetArticleRequest($url));
        $data = $response->json();
        $this->info(json_encode($data, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT));

        if($response->isCached()){
            $this->info(" is cached ? TRUE" . $response->isCached()); // true
        }else{
            $this->info(" is cached ? FALSE" . $response->isCached()); // false
        }
    }
}
