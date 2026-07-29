<x-layout title="Autores — citações.online">
    <section class="mb-10">
        <h1 class="font-serif text-4xl md:text-[40px] text-brand-dark leading-tight">
            Autores
        </h1>
        <p class="text-xs text-brand-muted mt-2 tracking-wide">
            {{ $authors->count() }} vozes reunidas, de poetas a filósofos.
        </p>
    </section>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12">
        @php
            $half = ceil($authors->count() / 2);
            $leftColumn = $authors->slice(0, $half);
            $rightColumn = $authors->slice($half);
        @endphp

        <div class="border-t border-brand-border/80 divide-y divide-brand-border/80">
            @foreach($leftColumn as $author)
                <a href="{{ route('authors.show', $author->slug) }}" 
                    class="py-5 flex items-center justify-between group hover:opacity-80 transition-opacity">
                    <span class="font-serif text-[19px] text-brand-dark group-hover:text-brand-accent transition-colors">
                        {{ $author->name }}
                    </span>
                    <span class="text-xs text-brand-muted font-mono">
                        {{ $author->quotes_count }}
                    </span>
                </a>
            @endforeach
        </div>

        <div class="border-t border-brand-border/80 divide-y divide-brand-border/80 mt-0">
            @foreach($rightColumn as $author)
                <a href="{{ route('authors.show', $author->slug) }}" 
                    class="py-5 flex items-center justify-between group hover:opacity-80 transition-opacity">
                    <span class="font-serif text-[19px] text-brand-dark group-hover:text-brand-accent transition-colors">
                        {{ $author->name }}
                    </span>
                    <span class="text-xs text-brand-muted font-mono">
                        {{ $author->quotes_count }}
                    </span>
                </a>
            @endforeach
        </div>
    </div>
</x-layout>