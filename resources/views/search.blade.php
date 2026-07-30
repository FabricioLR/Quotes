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
                class="w-full bg-[#FAF8F5] border border-brand-border/90 rounded-[2px] px-4 py-3.5 text-sm text-brand-dark placeholder-brand-muted/60 focus:outline-none focus:border-brand-accent transition-colors">
    </form>

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

    @if(!empty($query))
        <div class="mb-6">
            <span class="text-[10px] tracking-[0.25em] text-brand-muted uppercase font-semibold">
                RESULTADOS PARA "{{ $query }}"
            </span>
            <p class="text-xs text-brand-muted mt-1">
                {{ $quotes->total() }} {{ $quotes->total() == 1 ? 'citação encontrada' : 'citações encontradas' }}
            </p>
        </div>

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
</x-layout>