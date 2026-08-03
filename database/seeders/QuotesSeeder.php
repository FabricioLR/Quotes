<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Author;
use App\Models\Category;
use App\Models\Quote;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class QuotesSeeder extends Seeder
{
    public function run(): void
    {
        $categoriesData = [
            ['name' => 'Amor', 'slug' => 'amor', 'description' => 'Citações e mensagens sobre o amor, carinho e afeto.'],
            ['name' => 'Motivação', 'slug' => 'motivacao', 'description' => 'Frases inspiradoras para impulsionar o seu dia e seus objetivos.'],
            ['name' => 'Filosofia', 'slug' => 'filosofia', 'description' => 'Reflexões profundas sobre a existência e a condição humana.'],
            ['name' => 'Vida', 'slug' => 'vida', 'description' => 'Pensamentos marcantes sobre as lições e a jornada da vida.'],
            ['name' => 'Sabedoria', 'slug' => 'sabedoria', 'description' => 'Ensinamentos valiosos de grandes mentes da história.'],
            ['name' => 'Humor', 'slug' => 'humor', 'description' => 'Frases bem-humoradas e irônicas para descontrair.'],
        ];

        $categories = collect();
        foreach ($categoriesData as $cat) {
            $category = Category::firstOrCreate(
                ['slug' => $cat['slug']],
                $cat
            );
            $categories->put($category->slug, $category);
        }

        $authorsData = [
            ['name' => 'Oscar Wilde', 'slug' => 'oscar-wilde', 'bio' => 'Escritor, poeta e dramaturgo irlandês.'],
            ['name' => 'Fernando Pessoa', 'slug' => 'fernando-pessoa', 'bio' => 'Um dos maiores poetas da língua portuguesa.'],
            ['name' => 'Mário Quintana', 'slug' => 'mario-quintana', 'bio' => 'Poeta, tradutor e jornalista brasileiro.'],
            ['name' => 'Miguel Torga', 'slug' => 'miguel-torga', 'bio' => 'Um dos mais importantes escritores portugueses do século XX.'],
            ['name' => 'Sócrates', 'slug' => 'socrates', 'bio' => 'Filósofo grego do período clássico.'],
            ['name' => 'Nelson Mandela', 'slug' => 'nelson-mandela', 'bio' => 'Líder antirracista e ex-presidente da África do Sul.'],
            ['name' => 'Leonardo da Vinci', 'slug' => 'leonardo-da-vinci', 'bio' => 'Polímata italiano da Renascença.'],
            ['name' => 'Clarice Lispector', 'slug' => 'clarice-lispector', 'bio' => 'Uma das mais importantes escritoras brasileiras.'],
        ];

        $authors = collect();
        foreach ($authorsData as $auth) {
            $author = Author::firstOrCreate(
                ['slug' => $auth['slug']],
                $auth
            );
            $authors->put($author->slug, $author);
        }

        $quotesData = [
            [
                'author_slug' => 'oscar-wilde',
                'category_slug' => 'vida',
                'content' => 'Vivemos todos na sarjeta, mas alguns de nós olham para as estrelas.',
            ],
            [
                'author_slug' => 'fernando-pessoa',
                'category_slug' => 'filosofia',
                'content' => 'Navegar é preciso, viver não é preciso.',
            ],
            [
                'author_slug' => 'mario-quintana',
                'category_slug' => 'amor',
                'content' => 'Amar é mudar a alma de casa.',
            ],
            [
                'author_slug' => 'miguel-torga',
                'category_slug' => 'filosofia',
                'content' => 'Vale a pena viver, ainda que só para dizer que não vale a pena.',
            ],
            [
                'author_slug' => 'socrates',
                'category_slug' => 'filosofia',
                'content' => 'Uma vida sem reflexão não vale a pena ser vivida.',
            ],
            [
                'author_slug' => 'nelson-mandela',
                'category_slug' => 'sabedoria',
                'content' => 'A educação é a arma mais poderosa que podes usar para mudar o mundo.',
            ],
            [
                'author_slug' => 'leonardo-da-vinci',
                'category_slug' => 'motivacao',
                'content' => 'Onde há uma grande vontade, não podem existir grandes dificuldades.',
            ],
            [
                'author_slug' => 'clarice-lispector',
                'category_slug' => 'amor',
                'content' => 'Renda-se, como eu me rendi. Mergulhe no que você não conhece como eu mergulhei.',
            ],
        ];

        foreach ($quotesData as $q) {
            $author = $authors->get($q['author_slug']);
            $category = $categories->get($q['category_slug']);

            if ($author && $category) {
                $quote = Quote::firstOrCreate(
                    ['content' => $q['content']], 
                    [
                        'author_id' => $author->id,
                        'slug' => Str::slug(Str::limit($q['content'], 50, '')),
                        'views_count' => rand(10, 500),
                        'likes_count' => rand(5, 120),
                    ]
                );

                $quote->categories()->syncWithoutDetaching([$category->id]);
            }
        }
    }
}
