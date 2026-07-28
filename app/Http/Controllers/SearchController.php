<?php

namespace App\Http\Controllers;

use App\Services\SearchService;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;

class SearchController extends Controller
{
    public function __construct(
        protected SearchService $searchService
    ) {}

    public function __invoke(Request $request): View
    {
        $query = (string) $request->input('q', '');

        $quotes = $this->searchService->search($query);
        $suggestions = $this->searchService->getPopularSuggestions();

        return view('search', [
            'query'       => $query,
            'quotes'      => $quotes,
            'suggestions' => $suggestions,
        ]);
    }
}