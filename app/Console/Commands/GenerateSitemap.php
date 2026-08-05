<?php

namespace App\Console\Commands;

use App\Models\Author;
use App\Models\Category;
use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';

    protected $description = 'Generate the dynamic XML sitemap for citacoes.online';

    public function handle(): int
    {
        $sitemap = Sitemap::create();

        $sitemap->add(
            Url::create(route('home'))
                ->setPriority(1.0)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
        );

        $sitemap->add(
            Url::create(route('categories.index'))
                ->setPriority(0.8)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
        );

        $sitemap->add(
            Url::create(route('authors.index'))
                ->setPriority(0.8)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
        );

        $sitemap->add(
            Url::create(route('about'))
                ->setPriority(0.3)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
        );

        Author::has('quotes')->each(function (Author $author) use ($sitemap) {
            $sitemap->add(
                Url::create(route('authors.show', $author->slug))
                    ->setPriority(0.7)
                    ->setLastModificationDate($author->updated_at)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
            );
        });

        Category::has('quotes')->each(function (Category $category) use ($sitemap) {
            $sitemap->add(
                Url::create(route('categories.show', $category->slug))
                    ->setPriority(0.7)
                    ->setLastModificationDate($category->updated_at)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
            );
        });

        $sitemap->writeToFile(storage_path('app/sitemap.xml'));

        $this->info('Sitemap generated successfully at storage/app/sitemap.xml!');

        return Command::SUCCESS;
    }
}