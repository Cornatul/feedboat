<?php
declare(strict_types=1);
namespace Cornatul\Feeds\Http\Controllers;

use Cornatul\Feeds\Classes\Parser;
use Cornatul\Feeds\DTO\FeedDto;
use Cornatul\Feeds\Interfaces\ArticleRepositoryInterface;
use Cornatul\Feeds\Interfaces\FeedFinderInterface;
use Cornatul\Feeds\Interfaces\FeedRepositoryInterface;
use Cornatul\Feeds\Jobs\FeedExtractor;
use Cornatul\Feeds\Jobs\FeedImporter;
use Cornatul\Feeds\Models\Feed;
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

    final public function search():ViewContract
    {
        return view('feeds::search');
    }

    final public function import():ViewContract
    {
        return view('feeds::import');
    }


    /**
     * @throws ValidationException
     */
    final public function store(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'file' => 'required',
        ]);

        $file = $request->file('file')->store('feeds', 'public');

        dispatch(new FeedImporter($file));

        return Redirect::to('feeds')->with('success', 'Feeds imported successfully');
    }

}
