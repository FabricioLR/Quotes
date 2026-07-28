<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>citações.online — palavras que ficam</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..700;1,400..700&family=Plus+Jakarta+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        cream: '#FAF8F5',
                        brand: {
                            dark: '#1C1917',
                            muted: '#8A827A',
                            accent: '#796144',
                            border: '#E8E2D9',
                            badge: '#F3EFEA'
                        }
                    },
                    fontFamily: {
                        serif: ['Playfair Display', 'Georgia', 'serif'],
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-cream text-brand-dark font-sans antialiased min-h-screen flex flex-col justify-between selection:bg-brand-accent selection:text-white">

    <!-- Header Navigation -->
    <header class="w-full border-b border-brand-border/60 py-7 px-6 md:px-16">
        <div class="max-w-5xl mx-auto flex flex-col md:flex-row justify-between items-center gap-4">
            <a href="{{ route('home') }}" class="text-center md:text-left group">
                <span class="font-serif text-[26px] tracking-tight text-brand-dark">citações<span class="text-brand-accent/80 font-serif">.online</span></span>
                <span class="block text-[10px] tracking-[0.28em] text-brand-muted uppercase font-medium mt-0.5">PALAVRAS QUE FICAM</span>
            </a>

            <nav class="flex items-center gap-7 text-[13px] text-brand-muted">
                <a href="{{ route('home') }}" class="text-brand-dark border-b border-brand-dark pb-0.5">Início</a>
                <a href="{{ route('categories.index') }}" class="hover:text-brand-dark transition-colors">Categorias</a>
                <a href="{{ route('authors.index') }}" class="hover:text-brand-dark transition-colors">Autores</a>
                <a href="{{ route('search') }}" class="hover:text-brand-dark transition-colors">Pesquisar</a>
                <a href="{{ route('about') }}" class="hover:text-brand-dark transition-colors">Sobre</a>
            </nav>
        </div>
    </header>

    <!-- Main Content Container -->
    <main class="max-w-3xl mx-auto w-full px-6 pt-14 pb-20 flex-1">

        <!-- 1. CITAÇÃO DO DIA -->
        @if($featuredQuote)
            <section class="mb-14">
                <span class="text-[10px] tracking-[0.25em] text-brand-muted uppercase font-semibold">
                    CITAÇÃO DO DIA &middot; {{ now()->translatedFormat('d \d\e F \d\e Y') }}
                </span>

                <div class="mt-6">
                    <!-- Elegant Big Open Quote Mark -->
                    <span class="font-serif text-5xl text-brand-muted/40 block -mb-6 select-none">“</span>
                    
                    <blockquote class="font-serif text-[34px] leading-[1.25] text-brand-dark max-w-2xl">
                        {{ $featuredQuote->content }}
                    </blockquote>

                    <!-- Author and Category -->
                    <div class="mt-5 text-xs text-brand-muted tracking-wide flex items-center gap-1.5">
                        @if($featuredQuote->author)
                            <a href="{{ route('authors.show', $featuredQuote->author->slug) }}" class="text-brand-dark hover:underline font-normal">
                                {{ $featuredQuote->author->name }}
                            </a>
                        @endif

                        @if($firstCategory = $featuredQuote->categories->first())
                            <span>&middot;</span>
                            <a href="{{ route('categories.show', $firstCategory->slug) }}" class="uppercase tracking-[0.18em] text-[10px] text-brand-muted hover:text-brand-dark">
                                {{ $firstCategory->name }}
                            </a>
                        @endif
                    </div>

                    <!-- Buttons -->
                    <div class="mt-7 flex items-center gap-2.5">
                        <button onclick="copyToClipboard(@js($featuredQuote->content))" 
                                class="px-5 py-2 text-xs font-normal text-brand-dark bg-transparent border border-brand-border/90 rounded-[2px] hover:bg-brand-badge transition-colors">
                            Copiar
                        </button>
                        <button class="px-5 py-2 text-xs font-normal text-white bg-brand-accent rounded-[2px] hover:opacity-90 transition-opacity">
                            Partilhar
                        </button>
                    </div>
                </div>
            </section>
        @endif

        <!-- 2. EXPLORAR POR CATEGORIA -->
        <section class="mb-14 pt-4">
            <h2 class="text-[10px] tracking-[0.25em] text-brand-muted uppercase font-semibold mb-4">
                EXPLORAR POR CATEGORIA
            </h2>

            <div class="flex flex-wrap gap-2">
                @forelse($categories as $category)
                    <a href="{{ route('categories.show', $category->slug) }}" 
                       class="px-3 py-1.5 bg-[#FAF6F0] border border-brand-border/80 rounded-[2px] text-xs text-brand-dark hover:border-brand-accent/60 transition-colors flex items-center gap-1.5">
                        <span>{{ $category->name }}</span>
                        @if(isset($category->quotes_count))
                            <span class="text-brand-muted/70 text-[10px] font-mono">{{ $category->quotes_count }}</span>
                        @endif
                    </a>
                @empty
                    <p class="text-xs text-brand-muted italic">Nenhuma categoria cadastrada.</p>
                @endforelse
            </div>
        </section>

        <!-- 3. TAMBÉM PARA HOJE -->
        <section class="pt-2">
            <h2 class="text-[10px] tracking-[0.25em] text-brand-muted uppercase font-semibold mb-6">
                TAMBÉM PARA HOJE
            </h2>

            <div class="border-t border-brand-border/70 divide-y divide-brand-border/70">
                @forelse($recentQuotes as $quote)
                    <article class="py-7">
                        <blockquote class="font-serif text-[21px] text-brand-dark leading-snug">
                            “{{ $quote->content }}”
                        </blockquote>

                        <div class="mt-2.5 text-xs text-brand-muted flex items-center gap-1.5">
                            @if($quote->author)
                                <a href="{{ route('authors.show', $quote->author->slug) }}" class="text-brand-dark hover:underline">
                                    {{ $quote->author->name }}
                                </a>
                            @endif

                            @if($category = $quote->categories->first())
                                <span>&middot;</span>
                                <a href="{{ route('categories.show', $category->slug) }}" class="uppercase tracking-[0.18em] text-[10px] text-brand-muted hover:text-brand-dark">
                                    {{ $category->name }}
                                </a>
                            @endif
                        </div>
                    </article>
                @empty
                    <p class="text-xs text-brand-muted italic py-6">Nenhuma citação disponível.</p>
                @endforelse
            </div>
        </section>

    </main>

    <!-- Footer -->
    <footer class="w-full border-t border-brand-border/60 py-7 px-6 md:px-16 text-xs text-brand-muted">
        <div class="max-w-5xl mx-auto flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                citacoes.online &mdash; uma coleção de citações em português.
            </div>
            <nav class="flex items-center gap-6 text-[12px]">
                <a href="{{ route('categories.index') }}" class="hover:text-brand-dark transition-colors">Categorias</a>
                <a href="{{ route('authors.index') }}" class="hover:text-brand-dark transition-colors">Autores</a>
                <a href="{{ route('about') }}" class="hover:text-brand-dark transition-colors">Sobre</a>
            </nav>
        </div>
    </footer>

    <!-- Copy Script -->
    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                alert('Citação copiada com sucesso!');
            }).catch(err => {
                console.error('Erro ao copiar: ', err);
            });
        }
    </script>
</body>
</html>