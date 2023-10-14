<?php
declare(strict_types=1);
namespace Cornatul\Feeds\Jobs;

use Cornatul\Feeds\DTO\ArticleDto;
use Cornatul\Feeds\Contracts\ArticleRepositoryInterface;
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

    /**
     * @throws \JsonException
     */
    final public function handle(ArticleRepositoryInterface $articleRepository): void
    {

        logger(json_encode($this->article, JSON_THROW_ON_ERROR));

        $settings = [
            'header_style' => 'setext', // Set to 'atx' to output H1 and H2 headers as # Header1 and ## Header2
            'suppress_errors' => true, // Set to false to show warnings when loading malformed HTML
            'strip_tags' => true, // Set to true to strip tags that don't have markdown equivalents. N.B. Strips tags, not their content. Useful to clean MS Word HTML output.
            'strip_placeholder_links' => true, // Set to true to remove <a> that doesn't have href.
            'bold_style' => '**', // DEPRECATED: Set to '__' if you prefer the underlined style
            'italic_style' => '*', // DEPRECATED: Set to '_' if you prefer the underlined style
            'remove_nodes' => 'meta style script', // space-separated list of dom nodes that should be removed. example: 'meta style script'
            'hard_break' => true, // Set to true to turn <br> into `\n` instead of `  \n`
            'list_item_style' => '-', // Set the default character for each <li> in a <ul>. Can be '-', '*', or '+'
            'preserve_comments' => false, // Set to true to preserve comments, or set to an array of strings to preserve specific comments
            'use_autolinks' => false, // Set to true to use simple link syntax if possible. Will always use []() if set to false
            'table_pipe_escape' => '\|', // Replacement string for pipe characters inside markdown table cells
            'table_caption_side' => 'top', // Set to 'top' or 'bottom' to show <caption> content before or after table, null to suppress
        ];

        $converter = new \League\HTMLToMarkdown\HtmlConverter($settings);


        try {

            $postData = [
                'feed_id' => $this->feed->id,
                'source' => $this->source,
                'title' => $this->article->title,
                'date' => $this->article->date,
                'text' => $this->article->text,
                'html' => $this->article->html,
                'markdown' => $converter->convert($this->article->html),
                'banner' => $this->article->banner,
                'summary' => $this->article->summary,
                'authors' => json_encode($this->article->authors, JSON_THROW_ON_ERROR),
                'keywords' => json_encode($this->article->keywords, JSON_THROW_ON_ERROR),
                'images' => json_encode($this->article->images, JSON_THROW_ON_ERROR),
                'entities' => json_encode($this->article->entities, JSON_THROW_ON_ERROR),
                'social' => json_encode($this->article->social, JSON_THROW_ON_ERROR),
                'sentiment' => json_encode($this->article->sentiment, JSON_THROW_ON_ERROR),
            ];

            $articleRepository->create($postData);

        } catch (\Exception $exception) {
            info($exception->getMessage());
        }
    }
}
