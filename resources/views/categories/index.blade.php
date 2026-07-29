<x-layout title="Categorias — citações.online">
    <section class="mb-10">
        <h1 class="font-serif text-4xl md:text-[40px] text-brand-dark leading-tight">
            Categorias
        </h1>
        <p class="text-xs text-brand-muted mt-2 tracking-wide">
            Escolha um tema e leia as frases reunidas para esse estado de espírito.
        </p>
    </section>

    <div class="border-t border-brand-border/80 divide-y divide-brand-border/80">
        @forelse($categories as $category)
            <a href="{{ route('categories.show', $category->slug) }}" 
                class="py-6 flex items-center justify-between group hover:opacity-80 transition-opacity">
                <span class="font-serif text-2xl text-brand-dark group-hover:text-brand-accent transition-colors">
                    {{ $category->name }}
                </span>
                <span class="text-xs text-brand-muted tracking-wide">
                    {{ $category->quotes_count }} {{ $category->quotes_count == 1 ? 'citação' : 'citações' }}
                </span>
            </a>
        @empty
            <div class="py-12 text-center text-xs text-brand-muted italic">
                Nenhuma categoria disponível no momento.
            </div>
        @endforelse
    </div>
</x-layout>