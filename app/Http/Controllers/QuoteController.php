<?php

namespace App\Http\Controllers;

use App\Services\QuoteService;
use App\Models\Quote;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    public function __construct(
        protected QuoteService $quoteService,
    ) {}
    public function storeQuote(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'content' => ['required', 'string'],
            'author_id' => ['required', 'exists:authors,id'],
            'category_ids' => ['required', 'array'],
            'category_ids.*' => ['exists:categories,id'],
        ]);

        $this->quoteService->createQuote($validated);
        return redirect()->route('admin.panel', ['tab' => 'quotes'])->with('success', 'Citação criada.');
    }

    public function updateQuote(Request $request, Quote $quote): RedirectResponse
    {
        $validated = $request->validate([
            'content' => ['required', 'string'],
            'author_id' => ['required', 'exists:authors,id'],
            'category_ids' => ['required', 'array'],
            'category_ids.*' => ['exists:categories,id'],
        ]);

        $this->quoteService->updateQuote($quote, $validated);
        return redirect()->route('admin.panel', ['tab' => 'quotes'])->with('success', 'Citação atualizada.');
    }

    public function destroyQuote(Quote $quote): RedirectResponse
    {
        $this->quoteService->deleteQuote($quote);
        return redirect()->route('admin.panel', ['tab' => 'quotes'])->with('success', 'Citação eliminada.');
    }
}
