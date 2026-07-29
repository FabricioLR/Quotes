<x-layout title="Autores — citações.online">
    <section class="mb-10">
        <span class="text-[10px] tracking-[0.25em] text-brand-muted uppercase font-semibold">
            AUTOR
        </span>
        <h1 class="font-serif text-4xl md:text-[40px] text-brand-dark leading-tight mt-1">
            {{ $author->name }}
        </h1>
        <p class="text-xs text-brand-muted mt-2 tracking-wide">
            {{ $quotes->total() }} {{ $quotes->total() == 1 ? 'citação' : 'citações' }}
        </p>
    </section>

    <div class="border-t border-brand-border/80 divide-y divide-brand-border/80">
        @forelse($quotes as $quote)
            <article class="py-7">
                <blockquote class="font-serif text-[21px] text-brand-dark leading-snug">
                    “{{ $quote->content }}”
                </blockquote>

                <div class="mt-2.5 text-xs text-brand-muted flex items-center gap-1.5">
                    <span class="text-brand-dark font-normal">{{ $author->name }}</span>

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
                Nenhuma citação cadastrada para este autor.
            </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $quotes->links() }}
    </div>
</x-layout>