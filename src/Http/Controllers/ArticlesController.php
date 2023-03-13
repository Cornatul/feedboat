<?php
declare(strict_types=1);
namespace Cornatul\Feeds\Http\Controllers;

use Cornatul\Feeds\Interfaces\ArticleRepositoryInterface;
use Cornatul\Feeds\Interfaces\FeedFinderInterface;
use Cornatul\Feeds\Interfaces\FeedRepositoryInterface;
use Cornatul\Feeds\Jobs\FeedExtractor;
use Cornatul\Wordpress\Interfaces\WordpressRepositoryInterface;
use Cornatul\Wordpress\WordpressServiceProvider;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Contracts\View\View as ViewContract;
class ArticlesController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        $this->middleware('auth');
    }


    final public function articles(int $feedID, ArticleRepositoryInterface $articleRepository): ViewContract
    {
        $articles = $articleRepository->getArticlesByFeedId($feedID, 20);

        return view('feeds::articles', compact('articles'));
    }


    final public function article(int $articleID, ArticleRepositoryInterface $articleRepository): ViewContract
    {
        $article = $articleRepository->getArticleById($articleID);
        return view('feeds::article', compact('article'));

    }

    final public function update(int $articleID, Request $request, ArticleRepositoryInterface $articleRepository): RedirectResponse
    {
        $this->validate($request, [
            'title' => 'required',
            'markdown' => 'required',
        ]);

        $data = $request->except("_token");

        $articleRepository->update($articleID, $data);

        if (class_exists(WordpressServiceProvider::class)) {
            return \redirect()->route('wordpress.article.publish', ['articleID' => $articleID])
                ->with('success', 'Article updated successfully! Now redirecting you to the publish page.');
        }

        return redirect()->back()->with('success', 'Article updated successfully!');
    }


    public function publish(int $article_id, Request $request, ArticleRepositoryInterface $articleRepository)
    {
        $article = $articleRepository->getArticleById($article_id);

        return \view('feeds::publish', compact('article'));
    }


    public function allArticles(ArticleRepositoryInterface $repository): ViewContract
    {

        $articles = $repository->getAllArticles(20);

        return view('feeds::allArticles', compact('articles'));
    }
}
