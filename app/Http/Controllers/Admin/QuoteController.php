<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\QuoteUpdateRequest;
use App\Models\Quote;
use App\Services\{QuoteService, NotificationService};
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    protected $quoteService;
    protected $notificationService;

    public function __construct(
        QuoteService $quoteService,
        NotificationService $notificationService
    ) {
        $this->quoteService = $quoteService;
        $this->notificationService = $notificationService;
    }

    public function index(Request $request)
    {
        $quotes = Quote::with(['user','country','originCountry','originCity','destinationCountry','destinationCity'])
            ->when($request->status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->when($request->service_type, function ($query, $type) {
                $query->where('service_type', $type);
            })
            ->when($request->date_range, function ($query, $range) {
                if ($range === 'today') {
                    $query->whereDate('created_at', today());
                } elseif ($range === 'week') {
                    $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                }
            })
            ->latest()
            ->paginate(15);

        $stats = [
            'pending' => Quote::where('status', 'pending')->count(),
            'processing' => Quote::where('status', 'processing')->count(),
            'approved' => Quote::where('status', 'approved')->count(),
            'rejected' => Quote::where('status', 'rejected')->count()
        ];

        return view('admin.quotes.index', compact('quotes', 'stats'));
    }

    public function show(Quote $quote)
    {
        $quote->load(['user', 'attachments']);
        return view('admin.quotes.show', compact('quote'));
    }

    public function process(QuoteUpdateRequest $request, Quote $quote)
    {
        $this->quoteService->processQuote($quote, $request->validated());
        $this->notificationService->sendQuoteProcessedNotification($quote);

        return redirect()
            ->route('admin.quotes.index')
            ->with('success', 'Quote processed successfully');
    }

    public function reject(Request $request, Quote $quote)
    {
        $request->validate(['reason' => 'required|string']);

        $this->quoteService->rejectQuote($quote, $request->reason);
        $this->notificationService->sendQuoteRejectedNotification($quote, $request->reason);

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
        return $this->reject('admin.quotes.index');
    }
}
