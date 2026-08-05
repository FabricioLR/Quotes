<?php

namespace App\Services;

use App\Models\Author;
use App\Models\Quote;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;

class AuthorService
{
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

    public function createAuthor(array $data): Author
    {
        return Author::create([
            'name' => $data['name'],
            'slug' => Str::slug($data['name']),
            'bio' => $data['bio'] ?? null,
        ]);
    }

    public function updateAuthor(Author $author, array $data): Author
    {
        $author->update([
            'name' => $data['name'],
            'slug' => Str::slug($data['name']),
            'bio' => $data['bio'] ?? null,
        ]);

        return $author;
    }

    public function deleteAuthor(Author $author): void
    {
        $author->delete();
    }
}