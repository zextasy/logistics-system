<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\QuoteUpdateRequest;
use App\Models\Quote;
use App\Services\{QuoteService};
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    protected $quoteService;

    public function __construct(QuoteService $quoteService) {
        $this->quoteService = $quoteService;
    }

    public function index(Request $request)
    {

        $stats = [
            'pending' => Quote::where('status', 'pending')->count(),
            'processing' => Quote::where('status', 'processing')->count(),
            'quoted' => Quote::where('status', 'quoted')->count(),
            'rejected' => Quote::where('status', 'rejected')->count()
        ];

        return view('admin.quotes.index', compact('stats'));
    }

    public function show(Quote $quote)
    {
        $quote->load(['user', 'attachments']);
        return view('admin.quotes.show', compact('quote'));
    }

    public function reject(Request $request, Quote $quote)
    {
        $request->validate(['reason' => 'required|string']);

        $this->quoteService->rejectQuote($quote, $request->reason);

        return redirect()
            ->route('admin.quotes.index')
            ->with('success', 'Quote rejected successfully');
    }

    public function export(Request $request)
    {
        $quotes = $this->quoteService->getQuotesForExport($request->all());
        return $this->quoteService->generateExport($quotes);
    }

    public function destroy(Quote $quote)
    {
        $quote->delete();
    }
}
