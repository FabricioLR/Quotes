<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Área reservada — Citações.online</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..700;1,400..700&family=Plus+Jakarta+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

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
                            btn: '#785A3C',
                            btnHover: '#63492F',
                            border: '#E8E2D9',
                            inputBg: '#FAF8F5',
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

    <header class="w-full border-b border-brand-border/60 py-7 px-6 md:px-16">
        <div class="max-w-6xl mx-auto flex flex-col md:flex-row justify-between items-center gap-4">
            <a href="{{ url('/') }}" class="text-center md:text-left group inline-block">
                <div class="flex items-baseline justify-center md:justify-start font-serif leading-none">
                    <span class="text-3xl font-normal text-brand-dark">citações</span>
                    <span class="text-3xl font-normal text-brand-dark">.online</span>
                </div>
                <span class="block text-[9px] tracking-[0.28em] text-brand-muted uppercase font-medium mt-1">
                    PALAVRAS QUE FICAM
                </span>
            </a>

            <nav class="flex items-center gap-8 text-[13px] text-brand-muted">
                <a href="{{ url('/') }}" class="hover:text-brand-dark transition-colors">Início</a>
                <a href="{{ url('/categorias') }}" class="hover:text-brand-dark transition-colors">Categorias</a>
                <a href="{{ url('/autores') }}" class="hover:text-brand-dark transition-colors">Autores</a>
                <a href="{{ url('/pesquisar') }}" class="hover:text-brand-dark transition-colors">Pesquisar</a>
                <a href="{{ url('/sobre') }}" class="hover:text-brand-dark transition-colors">Sobre</a>
            </nav>
        </div>
    </header>

    {{-- Main Content --}}
    <main class="max-w-6xl mx-auto w-full px-6 pt-16 pb-20 flex-1">
        <div class="max-w-md">
            <h1 class="font-serif text-4xl text-brand-dark font-normal tracking-tight mb-2">
                Área reservada
            </h1>
            <p class="text-xs text-brand-muted mb-8 font-normal">
                Introduza o utilizador e a palavra-passe de administrador.
            </p>

            {{-- Form --}}
            <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="block text-xs text-brand-muted mb-1.5 font-normal">
                        Utilizador
                    </label>
                    <input 
                        type="email" 
                        name="email" 
                        id="email" 
                        value="{{ old('email') }}"
                        placeholder="admin"
                        required 
                        autofocus
                        class="w-full px-3 py-2 text-sm bg-transparent border border-brand-border rounded-[2px] focus:outline-none focus:border-brand-accent text-brand-dark transition-colors placeholder:text-brand-muted/50 @error('email') border-red-500 @enderror"
                    >
                    @error('email')
                        <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-xs text-brand-muted mb-1.5 font-normal">
                        Palavra-passe
                    </label>
                    <input 
                        type="password" 
                        name="password" 
                        id="password" 
                        placeholder="••••••••"
                        required 
                        class="w-full px-3 py-2 text-sm bg-transparent border border-brand-border rounded-[2px] focus:outline-none focus:border-brand-accent text-brand-dark transition-colors placeholder:text-brand-muted/50 @error('password') border-red-500 @enderror"
                    >
                    @error('password')
                        <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div class="pt-2">
                    <button 
                        type="submit" 
                        class="px-6 py-2 bg-brand-btn text-white text-xs font-normal rounded-[2px] hover:bg-brand-btnHover transition-colors cursor-pointer"
                    >
                        Entrar
                    </button>
                </div>
            </form>
        </div>
    </main>

    <footer class="w-full border-t border-brand-border/60 py-7 px-6 md:px-16 text-xs text-brand-muted">
        <div class="max-w-6xl mx-auto flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                citacoes.online — uma coleção de citações em português.
            </div>
            <nav class="flex items-center gap-6 text-[12px]">
                <a href="{{ url('/categorias') }}" class="hover:text-brand-dark transition-colors">Categorias</a>
                <a href="{{ url('/autores') }}" class="hover:text-brand-dark transition-colors">Autores</a>
                <a href="{{ url('/sobre') }}" class="hover:text-brand-dark transition-colors">Sobre</a>
            </nav>
        </div>
    </footer>

</body>
</html>