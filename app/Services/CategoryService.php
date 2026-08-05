<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Quote;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class CategoryService
{
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

    public function createCategory(array $data): Category
    {
        return Category::create([
            'name' => $data['name'],
            'slug' => Str::slug($data['name']),
            'description' => $data['description'] ?? null,
        ]);
    }

    public function updateCategory(Category $category, array $data): Category
    {
        $category->update([
            'name' => $data['name'],
            'slug' => Str::slug($data['name']),
            'description' => $data['description'] ?? null,
        ]);

        return $category;
    }

    public function deleteCategory(Category $category): void
    {
        $category->quotes()->detach();
        $category->delete();
    }
}