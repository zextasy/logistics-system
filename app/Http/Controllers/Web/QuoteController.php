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

    public function create()
    {
        return view('quotes.create');
    }


}
