<?php

namespace Cornatul\Feeds\Http\Controllers;

use Cornatul\Feeds\Interfaces\FeedInterface;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\View\View;

class FeedsController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index(FeedInterface $feed)
    {
        $feeds = $feed->find('technology', 'en');

        $results = $feeds->getFeeds();


        return view('feeds::index', compact('results'));
    }

    final public function search(Request $request, FeedInterface $feed): Application|Factory|\Illuminate\Contracts\View\View
    {
        $feeds = $feed->find($request->get('topic'), 'en');

        $results = $feeds->getFeeds();

        return view('feeds::index', compact('results'));
    }


    /**
     * @throws \JsonException
     */
    public function import(Request $request)
    {
        $request->validate([
            'feed' => 'required|json'
        ]);

        $feeds = json_decode($request->get('feed'), false, 512, JSON_THROW_ON_ERROR);

        dd($feeds);
        return redirect()->route('feeds.index');
    }


}
