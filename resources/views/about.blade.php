<x-layout title="Sobre — C.online">
    <h1 class="font-serif text-4xl md:text-[40px] text-brand-dark leading-tight mb-8">
        Sobre
    </h1>

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

        <div class="pt-6">
            <a href="{{ route('home') }}" class="text-xs text-brand-muted hover:text-brand-dark transition-colors inline-flex items-center gap-1.5">
                &larr; Voltar à citação do dia
            </a>
        </div>

    </div>
</x-layout>