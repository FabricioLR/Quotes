<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesquisar — citações.online</title>

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
                <a href="{{ route('home') }}" class="hover:text-brand-dark transition-colors">Início</a>
                <a href="{{ route('categories.index') }}" class="hover:text-brand-dark transition-colors">Categorias</a>
                <a href="{{ route('authors.index') }}" class="hover:text-brand-dark transition-colors">Autores</a>
                <a href="{{ route('search') }}" class="text-brand-dark border-b border-brand-dark pb-0.5">Pesquisar</a>
                <a href="{{ route('about') }}" class="hover:text-brand-dark transition-colors">Sobre</a>
            </nav>
        </div>
    </header>

    <!-- Main Content Container -->
    <main class="max-w-3xl mx-auto w-full px-6 pt-14 pb-20 flex-1">

        <!-- Page Header -->
        <section class="mb-8">
            <h1 class="font-serif text-4xl md:text-[40px] text-brand-dark leading-tight">
                Pesquisar
            </h1>
            <p class="text-xs text-brand-muted mt-2 tracking-wide">
                Escreva uma palavra, o nome de um autor ou um tema.
            </p>
        </section>

        <!-- Search Form -->
        <form action="{{ route('search') }}" method="GET" class="mb-8">
            <input type="text" 
                   name="q" 
                   value="{{ $query }}"
                   placeholder="ex.: coragem, Pessoa, amor" 
                   autofocus
                   class="w-full bg-[#FAF8F5] border border-brand-border/90 rounded-[2px] px-4 py-3.5 text-sm text-brand-dark placeholder-brand-muted/60 focus:outline-none focus:border-brand-accent transition-colors">
        </form>

        <!-- Suggestions Chips -->
        @if(empty($query) && !empty($suggestions))
            <div class="mb-12">
                <span class="text-[10px] tracking-[0.2em] text-brand-muted uppercase font-semibold block mb-3">
                    SUGESTÕES DE BUSCA
                </span>
                <div class="flex flex-wrap gap-2">
                    @foreach($suggestions as $suggestion)
                        <a href="{{ route('search', ['q' => $suggestion]) }}" 
                           class="px-3 py-1.5 bg-[#FAF6F0] border border-brand-border/80 rounded-[2px] text-xs text-brand-dark hover:border-brand-accent/60 transition-colors">
                            {{ $suggestion }}
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Results Section -->
        @if(!empty($query))
            <div class="mb-6">
                <span class="text-[10px] tracking-[0.25em] text-brand-muted uppercase font-semibold">
                    RESULTADOS PARA "{{ $query }}"
                </span>
                <p class="text-xs text-brand-muted mt-1">
                    {{ $quotes->total() }} {{ $quotes->total() == 1 ? 'citação encontrada' : 'citações encontradas' }}
                </p>
            </div>

            <!-- List -->
            <div class="border-t border-brand-border/80 divide-y divide-brand-border/80">
                @forelse($quotes as $quote)
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
                    <div class="py-12 text-center text-xs text-brand-muted italic">
                        Nenhuma citação encontrada para "{{ $query }}". Tente buscar por outros termos.
                    </div>
                @endforelse
            </div>

            @if($quotes->hasPages())
                <div class="mt-8">
                    {{ $quotes->links() }}
                </div>
            @endif
        @endif

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

</body>
</html>