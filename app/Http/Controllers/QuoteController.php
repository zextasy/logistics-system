<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Quote;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    public function create()
    {
        $data['countries'] = Country::all()->pluck('name');
        return view('quotes.create',$data);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'description' => 'required|string',
            'container_size' => 'nullable|string',
            'service_type' => 'required|string|max:255',
        ]);

        Quote::create($validated);

        return redirect()->route('quote.create')
            ->with('success', 'Quote request submitted successfully. We will contact you soon.');
    }

    public function index()
    {
        $quotes = Quote::latest()->paginate(10);
        return view('admin.quotes.index', compact('quotes'));
    }

    public function update(Request $request, Quote $quote)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,processed,rejected',
            'admin_notes' => 'nullable|string',
        ]);

        $quote->update($validated);

        return redirect()->route('admin.quotes.index')
            ->with('success', 'Quote status updated successfully');
    }
}
