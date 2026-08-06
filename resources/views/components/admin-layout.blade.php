@props([
    'title' => 'Painel — Citações.online',
    'activeTab' => 'quotes'
])

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <link rel="icon" type="image/png" href="/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="/favicon.svg" />
    <link rel="shortcut icon" href="/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png" />
    <link rel="manifest" href="/site.webmanifest" />
    
    <title>{{ $title }}</title>

    <style>
        html {
            scrollbar-gutter: stable;
        }
    </style>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..700;1,400..700&family=Plus+Jakarta+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
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
                <a href="{{ route('home') }}" class="hover:text-brand-dark transition-colors">Início</a>
                <a href="{{ route('categories.index') }}" class="hover:text-brand-dark transition-colors">Categorias</a>
                <a href="{{ route('authors.index') }}" class="hover:text-brand-dark transition-colors">Autores</a>
                <a href="{{ route('search') }}" class="hover:text-brand-dark transition-colors">Pesquisar</a>
                <a href="{{ route('about') }}" class="hover:text-brand-dark transition-colors">Sobre</a>
            </nav>
        </div>
    </header>

    <main class="max-w-4xl mx-auto w-full px-6 pt-12 pb-20 flex-1">
        @if (session('success'))
            <div class="mb-6 px-4 py-3 bg-brand-accent/10 border border-brand-accent/20 text-brand-dark text-xs rounded-[2px] flex items-center justify-between">
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 px-4 py-3 bg-red-500/10 border border-red-500/20 text-red-700 text-xs rounded-[2px]">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="flex justify-between items-start mb-6">
            <div>
                <span class="text-[10px] tracking-[0.25em] text-brand-muted uppercase font-semibold block mb-1">
                    PRIVADO
                </span>
                <h1 class="font-serif text-4xl text-brand-dark font-normal tracking-tight">
                    Painel
                </h1>
            </div>

            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="px-4 py-2 border border-brand-border text-xs text-brand-dark hover:bg-black/5 transition-colors cursor-pointer">
                    Terminar sessão
                </button>
            </form>
        </div>

        {{ $slot }}

    </main>

    {{-- Footer --}}
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