<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\QuoteRequest;
use App\Models\Quote;
use App\Services\QuoteService;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    protected $quoteService;

    public function __construct(QuoteService $quoteService)
    {
        $this->quoteService = $quoteService;
    }

    public function index()
    {
        $quotes = auth()->user()->quotes()
            ->latest()
            ->paginate(10);

        return view('quotes.index', compact('quotes'));
    }

    public function create()
    {
        return view('quotes.create', [
            'countries' => $this->quoteService->getCountries()
        ]);
    }

    public function store(QuoteRequest $request)
    {
        $quote = $this->quoteService->createQuote($request->validated());

        return redirect()
            ->route('quotes.show', $quote)
            ->with('success', 'Quote request submitted successfully');
    }

    public function show(Quote $quote)
    {
        $this->authorize('view', $quote);

        return view('quotes.show', compact('quote'));
    }

    public function attachments(Request $request, Quote $quote)
    {
        $this->authorize('view', $quote);

        $request->validate([
            'attachments.*' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240'
        ]);

        foreach ($request->file('attachments') as $file) {
            $this->quoteService->addAttachment($quote, $file);
        }

        return back()->with('success', 'Attachments uploaded successfully');
    }
}
