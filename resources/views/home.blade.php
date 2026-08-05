<x-layout title="C.online — palavras que ficam">
    @if($featuredQuote)
        <section class="mb-14">
            <span class="text-[10px] tracking-[0.25em] text-brand-muted uppercase font-semibold">
                CITAÇÃO DO DIA &middot; {{ now()->translatedFormat('d \d\e F \d\e Y') }}
            </span>

            <div class="mt-6">
                <span class="font-serif text-5xl text-brand-muted/40 block -mb-6 select-none">“</span>
                
                <blockquote class="font-serif text-[34px] leading-[1.25] text-brand-dark max-w-2xl">
                    <a href="{{ route('quotes.show', $featuredQuote->slug) }}" class="hover:text-brand-accent transition-colors">
                        {{ $featuredQuote->content }}
                    </a>
                </blockquote>

                <div class="mt-5 text-xs text-brand-muted tracking-wide flex items-center gap-1.5">
                    @if($featuredQuote->author)
                        <a href="{{ route('authors.show', $featuredQuote->author->slug) }}" class="text-brand-dark hover:underline font-normal">
                            {{ $featuredQuote->author->name }}
                        </a>
                    @endif

                    @if($firstCategory = $featuredQuote->categories->first())
                        <span>&middot;</span>
                        <a href="{{ route('categories.show', $firstCategory->slug) }}" class="uppercase tracking-[0.18em] text-[10px] text-brand-muted hover:text-brand-dark">
                            {{ $firstCategory->name }}
                        </a>
                    @endif
                </div>

                <div class="mt-7 flex items-center gap-2.5">
                    <button onclick="copyToClipboard(@js($featuredQuote->content))" 
                            class="hover:border-brand-accent/60 cursor-pointer px-5 py-2 text-xs font-normal text-brand-dark bg-transparent border border-brand-border/90 rounded-[2px] hover:bg-brand-badge transition-colors">
                        Copiar
                    </button>
                    <button class="cursor-pointer px-5 py-2 text-xs font-normal text-white bg-brand-accent rounded-[2px] hover:opacity-90 transition-opacity">
                        Partilhar
                    </button>
                </div>
            </div>
        </section>
    @endif

    <section class="mb-14 pt-4">
        <h2 class="text-[10px] tracking-[0.25em] text-brand-muted uppercase font-semibold mb-4">
            EXPLORAR POR CATEGORIA
        </h2>

        <div class="flex flex-wrap gap-2">
            @forelse($categories as $category)
                <a href="{{ route('categories.show', $category->slug) }}" 
                    class="px-3 py-1.5 bg-[#FAF6F0] border border-brand-border/80 rounded-[2px] text-xs text-brand-dark hover:border-brand-accent/60 transition-colors flex items-center gap-1.5">
                    <span>{{ $category->name }}</span>
                    @if(isset($category->quotes_count))
                        <span class="text-brand-muted/70 text-[10px] font-mono">{{ $category->quotes_count }}</span>
                    @endif
                </a>
            @empty
                <p class="text-xs text-brand-muted italic">Nenhuma categoria cadastrada.</p>
            @endforelse
        </div>
    </section>

    <section class="pt-2">
        <h2 class="text-[10px] tracking-[0.25em] text-brand-muted uppercase font-semibold mb-6">
            TAMBÉM PARA HOJE
        </h2>

        <div class="border-t border-brand-border/70 divide-y divide-brand-border/70">
            @forelse($recentQuotes as $quote)
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

                        @if($category = $quote->categories->first())
                            <span>&middot;</span>
                            <a href="{{ route('categories.show', $category->slug) }}" class="uppercase tracking-[0.18em] text-[10px] text-brand-muted hover:text-brand-dark">
                                {{ $category->name }}
                            </a>
                        @endif
                    </div>
                </article>
            @empty
                <p class="text-xs text-brand-muted italic py-6">Nenhuma citação disponível.</p>
            @endforelse
        </div>
    </section>
</x-layout>