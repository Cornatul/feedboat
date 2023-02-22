<?php

namespace Cornatul\Feeds\Http\Controllers;

use App\Interfaces\FeedRepositoryInterface;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class FeedsController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    final public function index()
    {
        return view('feeds::index');
    }

    final public function search(string $topic, FeedRepositoryInterface $feed): JsonResponse
    {

        $feedDto = $feed->find($topic, 'en');

        //todo implement a transformer
        $feeds = collect([
            'topic' => $feedDto->topics,
            "feeds" => $feedDto->getFeeds(),
        ]);

        return response()->json(  $feeds->toArray(),200,[],JSON_PRETTY_PRINT);
    }


    public function imported()
    {
        return view('feeds::imported');
    }

    final public function subscribe(Request $request, FeedRepositoryInterface $feedRepository)
    {
        $feedRepository->createFeed($request->all());

        return redirect()->route('feeds::imported');
    }

    final public function checkImported(string $url, FeedRepositoryInterface $feedRepository): JsonResponse
    {
        $url = str_replace('feed/', '', $url);
        return response()->json(['exists' => $feedRepository->imported($url)]);
    }
}
