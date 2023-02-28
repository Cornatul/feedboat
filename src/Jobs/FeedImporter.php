<?php
declare(strict_types=1);
namespace Cornatul\Feeds\Jobs;


use Carbon\Carbon;
use Cornatul\Feeds\Classes\Parser;
use Cornatul\Feeds\Models\Feed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Bus\Batch;
use Illuminate\Bus\Queueable;

use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Laminas\Feed\Reader\Reader;
use Symfony\Component\HttpFoundation\File\UploadedFile;
/**
 * @package Cornatul\Feeds\Jobs
 * @class FeedCrawlerJob
 */
class FeedImporter implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private string $file;

    public int $tries = 1;


    public function __construct(string $file)
    {
        $this->file = $file;
    }

    final public function handle(): void
    {
        logger('FeedImporter: ' . $this->file);

        $storage = File::get(storage_path("app/public/" . $this->file));

        $parser = new Parser();

        $parser->ParseOPML($storage);

        foreach ($parser->getOpmlContents() as $key => $value) {

            if(sizeof($value) > 4)
            {
                $feed = Feed::create([
                    'title' => $value['TEXT'],
                    "user_id" => 1,
                    "image" => "",
                    'description' => $value['TEXT'],
                    'score' => 1,
                    'subscribers' => 1,
                    'url' => $value['XMLURL'],
                    'sync' => Feed::SYNCING
                ]);
                dispatch(new FeedExtractor($feed))->onQueue('feed-extractor');
            }
        }
    }

    final public function failed($exception = null): void
    {
        $this->delete();
    }
}
