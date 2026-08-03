<?php

namespace App\Http\Controllers;

use App\Services\QuoteService;
use App\Services\CategoryService;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function __construct(
        protected QuoteService $quoteService,
        protected CategoryService $categoryService
    ) {}

    public function index(): View
    {
        $featuredQuote = $this->quoteService->getQuoteOfTheDay();

        $categories = $this->categoryService->getFeaturedCategories(limit: 6);

        $recentQuotes = $this->quoteService->getRecentQuotes(
            limit: 6, 
            excludeQuoteId: $featuredQuote?->id
        );

        return view('home', compact('featuredQuote', 'categories', 'recentQuotes'));
    }
}
