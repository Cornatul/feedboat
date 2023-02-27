<?php

namespace Cornatul\Feeds\Http\Controllers;

use Cornatul\Feeds\Interfaces\ArticleRepositoryInterface;
use Cornatul\Feeds\Interfaces\FeedFinderInterface;
use Cornatul\Feeds\Interfaces\FeedRepositoryInterface;
use Cornatul\Feeds\Jobs\FeedExtractor;
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
class FeedsController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        $this->middleware('auth');
    }

    final public function index(FeedRepositoryInterface $feedRepository): ViewContract
    {
        $feeds = $feedRepository->listFeeds(10);

        return view('feeds::index', compact('feeds'));
    }

    final public function articles(int $feedID, ArticleRepositoryInterface $articleRepository): ViewContract
    {
        $articles = $articleRepository->getArticlesByFeedId($feedID, 10);

        return view('feeds::articles', compact('articles'));
    }



    final public function article(int $articleID, ArticleRepositoryInterface $articleRepository): ViewContract
    {
        $article = $articleRepository->getArticleById($articleID);

    }
    final public function search():ViewContract
    {
        return view('feeds::search');
    }




}
