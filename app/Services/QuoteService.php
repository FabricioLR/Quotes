<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Quote;
use Illuminate\Support\Facades\Cache;

class QuoteService
{
    public function getQuoteOfTheDay(): ?Quote
    {
        $cacheKey = 'quote_of_the_day_id_' . now()->toDateString();

        $quoteId = Cache::remember($cacheKey, now()->endOfDay(), function () {
            return Quote::inRandomOrder()->value('id');
        });

        if (!$quoteId) {
            return null;
        }

        return Quote::with(['author', 'categories'])->find($quoteId);
    }

    public function getFeaturedCategories(int $limit = 6)
    {
        return Cache::remember("featured_categories_{$limit}", now()->addHours(12), function () use ($limit) {
            return Category::whereHas('quotes')
                ->withCount('quotes')
                ->orderByDesc('quotes_count')
                ->take($limit)
                ->get();
        });
    }

    public function getRecentQuotes(int $limit = 6, ?int $excludeQuoteId = null)
    {
        $cacheKey = "recent_quotes_{$limit}_ex_" . ($excludeQuoteId ?? 'none');

        return Cache::remember($cacheKey, now()->addHour(), function () use ($limit, $excludeQuoteId) {
            return Quote::with(['author', 'categories'])
                ->when($excludeQuoteId, fn($query) => $query->where('id', '!=', $excludeQuoteId))
                ->latest()
                ->take($limit)
                ->get();
        });
    }

    public function getAllCategories()
    {
        return Cache::remember('all_categories_list', now()->addHours(12), function () {
            return Category::whereHas('quotes')
                ->withCount('quotes')
                ->orderBy('name')
                ->get();
        });
    }
    public function getCategoryBySlug(string $slug, int $perPage = 10): array
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $quotes = Quote::with(['author', 'categories'])
            ->whereHas('categories', fn($q) => $q->where('categories.id', $category->id))
            ->latest()
            ->paginate($perPage);

        return [$category, $quotes];
    }

    public function getAllAuthors()
    {
        return Cache::remember('all_authors_list', now()->addHours(12), function () {
            return Author::whereHas('quotes')
                ->withCount('quotes')
                ->orderBy('name')
                ->get();
        });
    }
    
    public function getAuthorBySlug(string $slug, int $perPage = 10): array
    {
        $author = Author::where('slug', $slug)->firstOrFail();

        $quotes = Quote::with(['author', 'categories'])
            ->where('author_id', $author->id)
            ->latest()
            ->paginate($perPage);

        return [$author, $quotes];
    }
}