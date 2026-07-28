<?php

namespace App\Services;

use App\Models\Author;
use App\Models\Quote;

use Illuminate\Support\Facades\Cache;

class AuthorService
{
    /**
     * Get all authors with quotes count.
     */
    public function getAllAuthors()
    {
        return Cache::remember('all_authors_list', now()->addHours(12), function () {
            return Author::whereHas('quotes')
                ->withCount('quotes')
                ->orderBy('name')
                ->get();
        });
    }

    /**
     * Get an author by slug with their paginated quotes.
     */
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