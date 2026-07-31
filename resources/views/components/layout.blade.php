@props([
    'title' => 'C.online — palavras que ficam',
    'description' => 'Um arquivo tranquilo de citações em português — pensado para se ler como um livro, sem ruído e sem pressa.'
])

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="/favicon.svg" />
    <link rel="shortcut icon" href="/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png" />
    <link rel="manifest" href="/site.webmanifest" />
    <title>{{ $title }}</title>

    <meta name="description" content="{{ $description }}">
    <link rel="canonical" href="{{ url()->current() }}" />

    <meta property="og:type" content="website" />
    <meta property="og:title" content="{{ $title }}" />
    <meta property="og:description" content="{{ $description }}" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:site_name" content="citacoes.online" />

    <script type="application/ld+json">
        {
        "@@context": "https://schema.org",
        "@@type": "WebSite",
        "name": "citacoes.online",
        "url": "{{ config('app.url') }}",
        "description": "Arquivo de citações em português."
        }
    </script>

    <style>
        html {
            scrollbar-gutter: stable;
        }
    </style>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..700;1,400..700&family=Plus+Jakarta+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-cream text-brand-dark font-sans antialiased min-h-screen flex flex-col justify-between selection:bg-brand-accent selection:text-white">

    <header class="w-full border-b border-brand-border/60 py-7 px-6 md:px-16">
        <div class="max-w-5xl mx-auto flex flex-col md:flex-row justify-between items-center gap-4">
            <a href="{{ route('home') }}" class="text-center md:text-left group inline-block">
                <div class="flex items-baseline justify-center md:justify-start font-serif leading-none">
                    <span class="text-4xl font-normal text-brand-dark -mr-0.5">C</span>
                    <span class="text-xl font-normal text-brand-dark tracking-tight">.online</span>
                </div>
                <span class="block text-[10px] tracking-[0.28em] text-brand-muted uppercase font-medium mt-1">
                    PALAVRAS QUE FICAM
                </span>
            </a>

            <nav class="flex items-center gap-7 text-[13px] text-brand-muted">
                <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'text-brand-dark border-b border-brand-dark pb-0.5' : 'hover:text-brand-dark transition-colors' }}">Início</a>
                <a href="{{ route('categories.index') }}" class="{{ request()->routeIs('categories.*') ? 'text-brand-dark border-b border-brand-dark pb-0.5' : 'hover:text-brand-dark transition-colors' }}">Categorias</a>
                <a href="{{ route('authors.index') }}" class="{{ request()->routeIs('authors.*') ? 'text-brand-dark border-b border-brand-dark pb-0.5' : 'hover:text-brand-dark transition-colors' }}">Autores</a>
                <a href="{{ route('search') }}" class="{{ request()->routeIs('search') ? 'text-brand-dark border-b border-brand-dark pb-0.5' : 'hover:text-brand-dark transition-colors' }}">Pesquisar</a>
                <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'text-brand-dark border-b border-brand-dark pb-0.5' : 'hover:text-brand-dark transition-colors' }}">Sobre</a>
            </nav>
        </div>
    </header>

    <main class="max-w-3xl mx-auto w-full px-6 pt-14 pb-20 flex-1">
        {{ $slot }}
    </main>

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