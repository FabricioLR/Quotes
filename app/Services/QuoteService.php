<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Quote;
use App\Models\Author;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use InvalidArgumentException;
use Illuminate\Database\Eloquent\Collection;
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

    public function getQuoteWithRelated(Quote $quote, int $limit = 5): array
    {
        $quote->loadMissing(['author', 'categories']);

        $categoryIds = $quote->categories->pluck('id');

        $relatedQuotes = Quote::query()
            ->with(['author', 'categories'])
            ->where('id', '!=', $quote->id)
            ->where(function ($query) use ($quote, $categoryIds) {
                $query->where('author_id', $quote->author_id);
                
                if ($categoryIds->isNotEmpty()) {
                    $query->orWhereHas('categories', function ($q) use ($categoryIds) {
                        $q->whereIn('categories.id', $categoryIds);
                    });
                }
            })
            ->orderByRaw('author_id = ? DESC', [$quote->author_id])
            ->latest()
            ->take($limit)
            ->get();

        return [
            'quote' => $quote,
            'relatedQuotes' => $relatedQuotes,
        ];
    }

    public function createQuote(array $data): Quote
    {
        $quote = Quote::create([
            'content' => $data['content'],
            'author_id' => $data['author_id'],
            'slug' => Str::slug(Str::limit($data['content'], 40, '')),
        ]);

        if (!empty($data['category_ids'])) {
            $quote->categories()->sync($data['category_ids']);
        }

        return $quote;
    }

    public function updateQuote(Quote $quote, array $data): Quote
    {
        $quote->update([
            'content' => $data['content'],
            'author_id' => $data['author_id'],
        ]);

        if (isset($data['category_ids'])) {
            $quote->categories()->sync($data['category_ids']);
        }

        return $quote;
    }

    public function deleteQuote(Quote $quote): void
    {
        $quote->categories()->detach();
        $quote->delete();
    }

    public function importFromJsonFile(UploadedFile $file): int
    {
        $content = file_get_contents($file->getRealPath());
        $items = json_decode($content, true);

        if (!is_array($items)) {
            throw new InvalidArgumentException('O ficheiro não contém um JSON válido ou formatado como array.');
        }

        return $this->importArray($items);
    }

    public function importArray(array $items): int
    {
        $importedCount = 0;

        DB::transaction(function () use ($items, &$importedCount) {
            foreach ($items as $item) {
                $quoteText = $item['quote'] ?? $item['content'] ?? null;
                if (!$quoteText) {
                    continue;
                }

                $authorName = trim($item['author'] ?? 'Desconhecido');
                $author = Author::firstOrCreate(
                    ['slug' => Str::slug($authorName)],
                    ['name' => $authorName]
                );

                $quote = Quote::firstOrCreate(
                    ['slug' => Str::slug(Str::limit($quoteText, 40, ''))],
                    [
                        'content' => trim($quoteText),
                        'author_id' => $author->id,
                        'slug' => Str::slug(Str::limit($quoteText, 40, ''))
                    ]
                );

                $categoriesInput = $item['category'] ?? $item['categories'] ?? [];
                if (is_string($categoriesInput)) {
                    $categoriesInput = array_map('trim', explode(',', $categoriesInput));
                }

                $categoryIds = [];
                foreach ((array) $categoriesInput as $catName) {
                    $catName = trim($catName);
                    if ($catName) {
                        $category = Category::firstOrCreate(
                            ['slug' => Str::slug($catName)],
                            ['name' => $catName]
                        );
                        $categoryIds[] = $category->id;
                    }
                }

                if (!empty($categoryIds)) {
                    $quote->categories()->sync($categoryIds);
                }

                $importedCount++;
            }
        });

        return $importedCount;
    }
}