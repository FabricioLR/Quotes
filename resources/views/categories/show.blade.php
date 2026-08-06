<x-layout title="Categorias — citações.online">
        <section class="mb-10">
            <span class="text-[10px] tracking-[0.25em] text-brand-muted uppercase font-semibold">
                CATEGORIA
            </span>
            <h1 class="font-serif text-4xl md:text-[40px] text-brand-dark leading-tight mt-1">
                {{ $category->name }}
            </h1>
            @if($category->description)
                <p class="text-xs text-brand-muted mt-2 tracking-wide">
                    {{ $category->description }}
                </p>
            @endif
        </section>
        <div class="border-t border-brand-border/80 divide-y divide-brand-border/80">
            @forelse($quotes as $quote)
                <article class="py-7">
                    <blockquote class="font-serif text-[21px] text-brand-dark leading-snug">
                        <a href="{{ route('quotes.show', $quote->slug) }}" class="hover:text-brand-accent transition-colors">
                            “{{ $quote->content }}”
                        </a>
                    </blockquote>

                    <div class="mt-2.5 text-xs text-brand-muted flex items-center gap-1.5">
                        @if($quote->author)
                            <a href="{{ route('authors.show', $quote->author->slug) }}" class="text-brand-dark hover:underline">
                                {{ $quote->author->name }}
                            </a>
                        @endif
                    </div>
                </article>
            @empty
                <div class="py-12 text-center text-xs text-brand-muted italic">
                    Nenhuma citação encontrada nesta categoria.
                </div>
            @endforelse
        </div>
        <div class="mt-8">
            {{ $quotes->links() }}
        </div>
</x-layout>