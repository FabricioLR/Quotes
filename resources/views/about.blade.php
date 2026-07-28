<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre — citações.online</title>

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
                <a href="{{ route('search') }}" class="hover:text-brand-dark transition-colors">Pesquisar</a>
                <a href="{{ route('about') }}" class="text-brand-dark border-b border-brand-dark pb-0.5">Sobre</a>
            </nav>
        </div>
    </header>

    <!-- Main Content Container -->
    <main class="max-w-2xl mx-auto w-full px-6 pt-14 pb-20 flex-1">

    <!-- Page Heading -->
    <h1 class="font-serif text-4xl md:text-[40px] text-brand-dark leading-tight mb-8">
        Sobre
    </h1>

    <!-- Content Paragraphs -->
    <div class="space-y-6 text-sm md:text-[15px] text-brand-dark/90 leading-relaxed font-normal">
        
        <p class="text-base text-brand-dark font-normal leading-relaxed">
            O <strong class="font-semibold text-brand-dark">citacoes.online</strong> nasceu do desejo de criar um canto calmo na internet — um espaço para desacelerar, ler e guardar ideias que valem a pena ser lembradas.
        </p>

        <p>
            Sem distrações nem pressa, a ideia é folhear estas páginas como quem abre um livro antigo. Por aqui, já guardamos <span class="font-medium text-brand-dark">{{ $quotes_count }} citações</span> de <span class="font-medium text-brand-dark">{{ $authors_count }} autores</span>. Todos os dias, escolhemos uma nova citação para abrir a página inicial, compartilhada igualmente com quem passa por cá.
        </p>

        <p class="text-brand-muted text-xs pt-2">
            O projeto continua a crescer. Em breve, você poderá sugerir as suas frases favoritas, guardar coleções pessoais e criar imagens para compartilhar.
        </p>

        <!-- Return Link -->
        <div class="pt-6">
            <a href="{{ route('home') }}" class="text-xs text-brand-muted hover:text-brand-dark transition-colors inline-flex items-center gap-1.5">
                &larr; Voltar à citação do dia
            </a>
        </div>

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