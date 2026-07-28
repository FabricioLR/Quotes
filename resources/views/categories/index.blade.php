<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categorias — citações.online</title>

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
                <a href="{{ route('categories.index') }}" class="text-brand-dark border-b border-brand-dark pb-0.5">Categorias</a>
                <a href="{{ route('authors.index') }}" class="hover:text-brand-dark transition-colors">Autores</a>
                <a href="{{ route('search') }}" class="hover:text-brand-dark transition-colors">Pesquisar</a>
                <a href="{{ route('about') }}" class="hover:text-brand-dark transition-colors">Sobre</a>
            </nav>
        </div>
    </header>

    <!-- Main Content Container -->
    <main class="max-w-3xl mx-auto w-full px-6 pt-14 pb-20 flex-1">

        <!-- Page Header -->
        <section class="mb-10">
            <h1 class="font-serif text-4xl md:text-[40px] text-brand-dark leading-tight">
                Categorias
            </h1>
            <p class="text-xs text-brand-muted mt-2 tracking-wide">
                Escolha um tema e leia as frases reunidas para esse estado de espírito.
            </p>
        </section>

        <!-- Category List -->
        <div class="border-t border-brand-border/80 divide-y divide-brand-border/80">
            @forelse($categories as $category)
                <a href="{{ route('categories.show', $category->slug) }}" 
                   class="py-6 flex items-center justify-between group hover:opacity-80 transition-opacity">
                    <span class="font-serif text-2xl text-brand-dark group-hover:text-brand-accent transition-colors">
                        {{ $category->name }}
                    </span>
                    <span class="text-xs text-brand-muted tracking-wide">
                        {{ $category->quotes_count }} {{ $category->quotes_count == 1 ? 'citação' : 'citações' }}
                    </span>
                </a>
            @empty
                <div class="py-12 text-center text-xs text-brand-muted italic">
                    Nenhuma categoria disponível no momento.
                </div>
            @endforelse
        </div>

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