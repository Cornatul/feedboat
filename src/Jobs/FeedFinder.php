<?php
declare(strict_types=1);
namespace Cornatul\Feeds\Jobs;

use Cornatul\Feeds\Models\Feed;
use GuzzleHttp\ClientInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class FeedFinder  implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Feed $feed;
    public function __construct(Feed $feed)
    {
        $this->feed = $feed;
    }

    final public function handle(ClientInterface $client): void
    {
        try{
            $response = $client->post("https://v1.nlpapi.org/feed-finder", [
                'json' => [
                    'link' => $this->feed->url
                ]
            ]);

            $collection = (
                json_decode(
                    $response->getBody()->getContents(),
                    false,
                    512,
                    JSON_THROW_ON_ERROR
                )
            );

            $feedUrl = ($collection->data->response[0]);
            $this->feed->url = $feedUrl;
            $this->feed->save();
            dispatch(new FeedExtractor($this->feed))->onQueue("feed-extractor");

        }catch (\Exception $exception){
            info($exception->getMessage());
        }
    }
}
