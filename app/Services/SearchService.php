<?php

namespace App\Services;

use App\Models\Quote;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

class SearchService
{
    protected int $minQueryLength = 2;

    protected int $perPage = 12;

    public function search(string $term, ?int $perPage = null): LengthAwarePaginator
    {
        $queryTerm = $this->normalizeTerm($term);
        $limit = $perPage ?? $this->perPage;

        if (mb_strlen($queryTerm) < $this->minQueryLength) {
            return new LengthAwarePaginator([], 0, $limit, 1, [
                'path' => request()->url(),
                'query' => request()->query(),
            ]);
        }

        $searchPattern = "%{$queryTerm}%";

        return Quote::query()
            ->with(['author', 'categories'])
            ->where(function ($builder) use ($searchPattern) {
                $builder->whereRaw('UNACCENT(LOWER(content)) LIKE ?', [$searchPattern])
                    ->orWhereHas('author', function ($authorQuery) use ($searchPattern) {
                        $authorQuery->whereRaw('UNACCENT(LOWER(name)) LIKE ?', [$searchPattern]);
                    })
                    ->orWhereHas('categories', function ($categoryQuery) use ($searchPattern) {
                        $categoryQuery->whereRaw('UNACCENT(LOWER(name)) LIKE ?', [$searchPattern]);
                    });
            })
            ->latest()
            ->paginate($limit)
            ->appends(['q' => $term]);
    }

    public function getPopularSuggestions(): array
    {
        return [
            'coragem',
            'Pessoa',
            'amor',
            'vida',
            'sabedoria',
            'Sócrates',
        ];
    }

    protected function normalizeTerm(string $term): string
    {
        $clean = Str::squish(strip_tags(trim($term)));

        return mb_strtolower(Str::ascii($clean), 'UTF-8');
    }
}