<?php

namespace Cornatul\Feeds\Jobs;

use Cornatul\Feeds\DTO\ArticleDto;
use Cornatul\Feeds\Interfaces\ArticleRepositoryInterface;
use Cornatul\Feeds\Models\Article;
use Cornatul\Feeds\Models\Feed;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class SaveArticle implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    private ArticleDto $article;
    private Feed $feed;
    private string $source;

    public function __construct(ArticleDto $article, Feed $feed, string $source)
    {
        $this->article = $article;
        $this->feed = $feed;
        $this->source = $source;
    }

    final public function handle(ArticleRepositoryInterface $articleRepository): void
    {
        try {

            $postData = [
                'feed_id' => $this->feed->id,
                'source' => $this->source,
                'title' => $this->article->title,
                'date' => $this->article->date,
                'text' => $this->article->text,
                'html' => $this->article->html,
                'markdown' => $this->article->markdown,
                'banner' => $this->article->banner,
                'summary' => $this->article->summary,
                'authors' => json_encode($this->article->authors, JSON_THROW_ON_ERROR),
                'keywords' => json_encode($this->article->keywords, JSON_THROW_ON_ERROR),
                'images' => json_encode($this->article->images, JSON_THROW_ON_ERROR),
                'entities' => json_encode($this->article->entities, JSON_THROW_ON_ERROR),
            ];

            $articleRepository->create($postData);

        } catch (\Exception $exception) {
            info($exception->getMessage());
        }
    }
}
