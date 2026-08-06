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

            <div class="mt-7 flex items-center gap-2.5">
                <button 
                    type="button"
                    onclick="copyAndFeedback(this, @js($quote->content) + ' - ' + @js($quote->author->name))"
                    class="hover:border-brand-accent/60 cursor-pointer px-5 py-2 text-xs font-normal text-brand-dark bg-transparent border border-brand-border/90 rounded-[2px] hover:bg-brand-badge transition-all min-w-[80px]"
                >
                    Copiar
                </button>
                <button class="cursor-pointer px-5 py-2 text-xs font-normal text-white bg-brand-accent rounded-[2px] hover:opacity-90 transition-opacity">
                    Partilhar
                </button>
            </div>
        </div>

        <hr class="border-stone-200 my-10" />

        <section>
            <h2 class="text-xs tracking-widest text-stone-400 uppercase font-semibold mb-6">
                Mais Citações Relacionadas
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
    <script>
        async function copyAndFeedback(button, text) {
            if (!text) return;

            try {
                if (navigator.clipboard && window.isSecureContext) {
                    await navigator.clipboard.writeText(text);
                } else {
                    const textarea = document.createElement('textarea');
                    textarea.value = text;
                    textarea.style.position = 'fixed';
                    textarea.style.opacity = '0';
                    document.body.appendChild(textarea);
                    textarea.focus();
                    textarea.select();
                    document.execCommand('copy');
                    document.body.removeChild(textarea);
                }

                const originalText = button.textContent;
                button.textContent = 'Copiado!';
                button.classList.add('font-medium');
                setTimeout(() => {
                    button.textContent = originalText;
                    button.classList.remove('font-medium');
                }, 2000);

            } catch (err) {
                console.error('Failed to copy: ', err);
            }
        }
    </script>
</x-layouts>