<?php

namespace App\Http\Controllers;

use App\Services\QuoteService;
use Illuminate\Contracts\View\View;

class CategoryController extends Controller
{
    public function __construct(
        protected QuoteService $quoteService
    ) {}

    public function index(): View
    {
        $categories = $this->quoteService->getAllCategories();

        return view('categories.index', compact('categories'));
    }

    public function show(string $slug): View
    {
        [$category, $quotes] = $this->quoteService->getCategoryBySlug($slug);

        return view('categories.show', compact('category', 'quotes'));
    }
}