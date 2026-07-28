<?php

namespace App\Http\Controllers;

use App\Services\QuoteService;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function __construct(
        protected QuoteService $quoteService
    ) {}

    public function index(): View
    {
        $featuredQuote = $this->quoteService->getQuoteOfTheDay();

        $categories = $this->quoteService->getFeaturedCategories(limit: 6);

        $recentQuotes = $this->quoteService->getRecentQuotes(
            limit: 6, 
            excludeQuoteId: $featuredQuote?->id
        );

        return view('home', compact('featuredQuote', 'categories', 'recentQuotes'));
    }
}
