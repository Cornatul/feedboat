<?php
declare(strict_types=1);
namespace Cornatul\Feeds\Http\Controllers;

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
class FeedsApiController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        $this->middleware('auth');
    }

    final public function searchAction(string $topic, FeedFinderInterface $feed): JsonResponse
    {

        $feedDto = $feed->find($topic, 'en');

        $feeds = collect([
            'topics' => $feedDto->topics,
            "feeds" => $feedDto->getFeeds(),
            "feed" => $feedDto
        ]);

        return response()->json(  $feeds->toArray(),200,[],JSON_PRETTY_PRINT);
    }

    final public function subscribeAction(Request $request, FeedRepositoryInterface $feedRepository): JsonResponse
    {
        $response = $feedRepository->createFeed($request->all());
        if($response){
            $feed = $feedRepository->findFeed('url',$request->get('url'));
            dispatch(new FeedExtractor($feed))->onQueue("feed-extractor");
        }
        return response()->json($response);
    }

}
