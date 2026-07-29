<x-layout title="Pesquisar — C.online">
    <section class="mb-8">
        <h1 class="font-serif text-4xl md:text-[40px] text-brand-dark leading-tight">
            Pesquisar
        </h1>
        <p class="text-xs text-brand-muted mt-2 tracking-wide">
            Escreva uma palavra, o nome de um autor ou um tema.
        </p>
    </section>

    <form action="{{ route('search') }}" method="GET" class="mb-8">
        <input type="text" 
               name="q" 
               value="{{ $query }}"
               placeholder="ex.: coragem, Pessoa, amor" 
               autofocus
               class="w-full bg-[#FAF8F5] border border-brand-border/90 rounded-[2px] px-4 py-3.5 text-sm text-brand-dark focus:outline-none focus:border-brand-accent">
    </form>

    <!-- Search Results Loop -->
    @if(!empty($query))
        <div class="border-t border-brand-border/80 divide-y divide-brand-border/80">
            @forelse($quotes as $quote)
                <article class="py-7">
                    <blockquote class="font-serif text-[21px] text-brand-dark leading-snug">
                        “{{ $quote->content }}”
                    </blockquote>
                </article>
            @empty
                <p class="py-12 text-center text-xs text-brand-muted">Nenhum resultado encontrado.</p>
            @endforelse
        </div>
    @endif
</x-layout>