<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\QuoteUpdateRequest;
use App\Models\Quote;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function index(Request $request)
    {
        $quotes = Quote::with('user')
            ->when($request->status, function($query, $status) {
                $query->where('status', $status);
            })
            ->when($request->service_type, function($query, $type) {
                $query->where('service_type', $type);
            })
            ->latest()
            ->paginate(15);

        $stats = [
            'pending' => Quote::where('status', 'pending')->count(),
            'processing' => Quote::where('status', 'processing')->count(),
            'approved' => Quote::where('status', 'approved')->count(),
            'rejected' => Quote::where('status', 'rejected')->count(),
        ];

        return view('admin.quotes.index', compact('quotes', 'stats'));
    }

    public function show(Quote $quote)
    {
        $quote->load('user');
        return view('admin.quotes.show', compact('quote'));
    }

    public function update(QuoteUpdateRequest $request, Quote $quote)
    {
        $quote->update($request->validated());

        if ($request->status === 'processed') {
            $this->notificationService->sendQuoteProcessedNotification($quote);
        }

        return redirect()
            ->route('admin.quotes.index')
            ->with('success', 'Quote updated successfully');
    }

    public function destroy(Quote $quote)
    {
        $quote->delete();
        return redirect()
            ->route('admin.quotes.index')
            ->with('success', 'Quote deleted successfully');
    }
}
