<x-layout title="Citação — citações.online">
    <main class="max-w-4xl mx-auto px-6 py-12 text-stone-800">
        <span class="text-xs tracking-widest text-stone-400 uppercase font-semibold">
            {{ $typeLabel ?? 'Citação' }}
        </span>

        <div class="mt-6 mb-12">
            <span class="text-5xl text-stone-300 font-serif leading-none select-none">“</span>
            <h1 class="text-3xl md:text-4xl font-serif text-stone-900 leading-snug -mt-4 mb-6">
                {{ $quote->content }}
            </h1>

            <div class="flex items-center gap-2 text-sm text-stone-500 mb-8">
                <a href="{{ route('authors.show', $quote->author) }}" class="font-medium text-stone-800 hover:underline">
                    {{ $quote->author->name }}
                </a>
                @if($firstCategory = $quote->categories->first())
                    <span>&middot;</span>
                    <a href="{{ route('categories.show', $firstCategory->slug) }}" class="uppercase text-xs tracking-wider text-stone-400 hover:text-stone-600">
                        {{ $firstCategory->name }}
                    </a>
                @endif
            </div>

            <div class="flex items-center gap-3">
                <button 
                    x-data 
                    @click="navigator.clipboard.writeText('{{ $quote->content }} - {{ $quote->author->name }}')"
                    class="cursor-pointer px-5 py-2 text-sm border border-stone-300 rounded hover:bg-stone-100 transition"
                >
                    Copiar
                </button>
                <button class="cursor-pointer px-5 py-2 text-sm bg-amber-900 text-white rounded hover:bg-amber-950 transition">
                    Partilhar
                </button>
            </div>
        </div>

        <hr class="border-stone-200 my-10" />

        <section>
            <h2 class="text-xs tracking-widest text-stone-400 uppercase font-semibold mb-6">
                Mais de {{ $quote->author->name }}
            </h2>

            <div class="space-y-8">
                @foreach($relatedQuotes as $related)
                    <article class="pb-6 border-b border-stone-100 last:border-0">
                        <blockquote class="text-xl font-serif text-stone-800 leading-relaxed mb-3">
                            <a href="{{ route('quotes.show', $related->slug) }}" class="hover:text-brand-accent transition-colors">
                                “{{ $related->content }}”
                            </a>
                        </blockquote>
                        <div class="mt-2.5 text-xs text-brand-muted flex items-center gap-1.5">
                            @if($category = $related->categories->first())
                                <a href="{{ route('categories.show', $category->slug) }}" class="uppercase tracking-[0.18em] text-[10px] text-brand-muted hover:text-brand-dark">
                                    {{ $category->name }}
                                </a>
                            @endif
                        </div>
                    </article>
                @endforeach
            </div>
        </section>

    </main>
</x-layouts>