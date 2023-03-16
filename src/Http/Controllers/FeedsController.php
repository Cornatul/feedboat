<?php
declare(strict_types=1);
namespace Cornatul\Feeds\Http\Controllers;

use Cornatul\Feeds\Classes\Parser;
use Cornatul\Feeds\DTO\FeedDto;
use Cornatul\Feeds\Repositories\Interfaces\ArticleRepositoryInterface;
use Cornatul\Feeds\Repositories\Interfaces\FeedRepositoryInterface;
use Cornatul\Feeds\Interfaces\FeedFinderInterface;
use Cornatul\Feeds\Jobs\FeedExtractor;
use Cornatul\Feeds\Jobs\FeedImporter;
use Cornatul\Feeds\Models\Feed;
use Cornatul\Feeds\Repositories\Interfaces\SortableInterface;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Illuminate\Contracts\View\View as ViewContract;
use imelgrat\OPML_Parser\OPML_Parser;
use Spatie\QueryBuilder\QueryBuilder;

class FeedsController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        $this->middleware('auth');
    }


    final public function index(
        Request $request,
        FeedRepositoryInterface $feedRepository,
        SortableInterface $sortable
    )
    : ViewContract
    {
        $feeds = $feedRepository->listFeeds();

        return view('feeds::index', compact('feeds'));
    }

    final public function search():ViewContract
    {
        return view('feeds::search');
    }

    final public function import():ViewContract
    {
        return view('feeds::import');
    }


    /**
     * //todo replace this with the validation class created
     * @throws ValidationException
     */
    final public function store(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'file' => 'required',
        ]);

        $file = $request->file('file')?->store('feeds', 'public');

        dispatch(new FeedImporter($file));

        return redirect('feeds')->with('success', 'Feeds imported successfully');
    }

    //create a function for deleteing a feed
    final public function destroy(int $id, FeedRepositoryInterface $feedRepository): RedirectResponse
    {
        $feedRepository->deleteFeed($id);

        return Redirect::to('feeds')->with('success', 'Feed deleted successfully');
    }


    // create a function that will sync the feed
    final public function sync(int $id, FeedRepositoryInterface $feedRepository): RedirectResponse
    {
        $feed = $feedRepository->getFeed($id);

        dispatch(new FeedExtractor($feed));

        return Redirect::to('feeds')->with('success', 'Feed synced successfully');
    }


}
