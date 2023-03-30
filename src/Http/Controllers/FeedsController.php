<?php
declare(strict_types=1);
namespace Cornatul\Feeds\Http\Controllers;




use Cornatul\Feeds\Repositories\Interfaces\FeedRepositoryInterface;
use Cornatul\Feeds\Jobs\FeedExtractor;
use Cornatul\Feeds\Jobs\FeedImporter;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\View\View as ViewContract;

class FeedsController extends Controller
{

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private array $validationFields = [
        'file' => 'required|file|mimes:xml,opml',
    ];

    private FeedRepositoryInterface $feedRepository;

    public function __construct(
        FeedRepositoryInterface $feedRepository,
    )
    {
        $this->middleware('auth');

        $this->feedRepository = $feedRepository;
    }

    final public function index(): ViewContract
    {
        $feeds = $this->feedRepository->listFeeds();

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
        $this->validate($request, $this->validationFields);

        $file = $request->file('file')?->store('feeds', 'public');

        dispatch(new FeedImporter($file));

        return redirect('feeds')->with('success', 'Feeds imported successfully');
    }

    final public function destroy(int $id, FeedRepositoryInterface $feedRepository): RedirectResponse
    {
        $feedRepository->deleteFeed($id);

        return redirect('feeds')->with('success', 'Feed deleted successfully');
    }


    final public function sync(int $id, FeedRepositoryInterface $feedRepository): RedirectResponse
    {
        $feed = $feedRepository->getFeed($id);

        dispatch(new FeedExtractor($feed));

        return redirect('feeds')->with('success', 'Feed synced successfully');
    }


}
