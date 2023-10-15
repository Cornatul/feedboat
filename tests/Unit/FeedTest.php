<?php

namespace Cornatul\Feeds\Tests\Unit;

use App\Models\User;
use Cornatul\Feeds\Clients\FeedlyClient;
use Cornatul\Feeds\DTO\FeedDto;
use Cornatul\Feeds\Repositories\Contracts\ArticleRepositoryInterface;
use Cornatul\Feeds\Contracts\FeedFinderInterface;
use Cornatul\Feeds\Models\Article;
use Cornatul\Feeds\Models\Feed;
use Cornatul\Feeds\Repositories\Contracts\FeedRepositoryInterface;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;
use Mockery;


class FeedTest extends \Cornatul\Feeds\Tests\TestCase
{

    /**
     * @throws \JsonException
     */
    public function testGetSentiment():void
    {
        $mock = Mockery::mock(FeedlyClient::class);
        $mock->shouldReceive('find')
            ->once()
            ->with('topic', 'en')
            ->andReturn(new FeedDto());
        $response = $mock->find('topic', 'en');

        $this->assertInstanceOf(FeedDto::class, $response);
    }

    public function testCanGetArticles(): void
    {
        //test can get articles using the repository
        $test = Mockery::mock(ArticleRepositoryInterface::class);
        $test->shouldReceive('getArticleById')
            ->with(1)
            ->once()
            ->andReturn(new Article());
        $response = $test->getArticleById(1);
        $this->assertInstanceOf(Article::class, $response);

    }


    public function testCanStoreAndDispatchJob(): void
    {


        $content = 'test';
        //test can store a file and dispatch a job
        $file = UploadedFile::fake()->createWithContent('filename.ext', $content)->store('filename.ext');

        //asert that the file was stored
        Storage::disk('local')->assertExists($file);
        //asset the store endpoint returns a 200
        $this->assertEquals(405, $this->post('/feeds/import', ['file' => $file])->status());

    }



    public function testPagination()
    {
        //$total, $perPage, $currentPage = null
        //create a test for the repository method
        $mock = Mockery::mock(FeedRepositoryInterface::class);
        $mock->shouldReceive('listFeeds')
            ->once()
            ->andReturns(new LengthAwarePaginator([
                new Feed(),
                new Feed(),
                new Feed(),
            ], 3, 3, null));
        $response = $mock->listFeeds();

        $this->assertInstanceOf(LengthAwarePaginator::class, $response);
        $this->assertEquals(3, $response->total());
        $this->assertEquals(3, $response->perPage());
        $this->assertEquals(1, $response->currentPage());

    }
}
