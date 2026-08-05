<?php

namespace App\Services;

use App\Models\Quote;
use App\Models\Author;
use App\Models\Category;
use Illuminate\Support\Collection;

class PanelService
{
    public function getDashboardData(string $tab = 'quotes', ?string $search = null): array
    {
        return [
            'counts' => [
                'quotes' => Quote::count(),
                'authors' => Author::count(),
                'categories' => Category::count(),
            ],
            'activeTab' => $tab,
            'quotes' => $tab === 'quotes' ? $this->getFilteredQuotes($search) : collect(),
            'authors' => $tab === 'authors' ? Author::withCount('quotes')->orderBy('name')->get() : collect(),
            'categories' => $tab === 'categories' ? Category::withCount('quotes')->orderBy('name')->get() : collect(),
            'allAuthors' => Author::orderBy('name')->get(),
            'allCategories' => Category::orderBy('name')->get(),
        ];
    }

    public function getFilteredQuotes(?string $search): Collection
    {
        return Quote::with(['author', 'categories'])
            ->when($search, function ($query, $search) {
                $query->where('content', 'like', "%{$search}%")
                    ->orWhereHas('author', fn($q) => $q->where('name', 'like', "%{$search}%"))
                    ->orWhereHas('categories', fn($q) => $q->where('name', 'like', "%{$search}%"));
            })
            ->latest()
            ->get();
    }
}