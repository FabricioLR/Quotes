<x-admin-layout title="Painel — Citações.online" :activeTab="$activeTab">
    
    <div x-data="{ showNewForm: false }">
        
        <div class="flex items-center gap-2 mb-8 text-xs flex-wrap">
            <a href="{{ route('admin.panel', ['tab' => 'quotes']) }}" 
               class="px-4 py-2.5 border border-brand-accent transition-colors {{ $activeTab === 'quotes' ? 'bg-brand-accent text-white border-brand-accent' : 'border-brand-border bg-transparent text-brand-dark hover:border-brand-dark' }}">
                Citações ({{ $counts['quotes'] }})
            </a>

            <a href="{{ route('admin.panel', ['tab' => 'authors']) }}" 
               class="px-4 py-2.5 border border-brand-accent transition-colors {{ $activeTab === 'authors' ? 'bg-brand-accent text-white border-brand-accent' : 'border-brand-border bg-transparent text-brand-dark hover:border-brand-dark' }}">
                Autores ({{ $counts['authors'] }})
            </a>

            <a href="{{ route('admin.panel', ['tab' => 'categories']) }}" 
               class="px-4 py-2.5 border border-brand-accent transition-colors {{ $activeTab === 'categories' ? 'bg-brand-accent text-white border-brand-accent' : 'border-brand-border bg-transparent text-brand-dark hover:border-brand-dark' }}">
                Categorias ({{ $counts['categories'] }})
            </a>

            {{-- NEW TAB BUTTON --}}
            <a href="{{ route('admin.panel', ['tab' => 'bulk']) }}" 
               class="px-4 py-2.5 border border-brand-accent transition-colors {{ $activeTab === 'bulk' ? 'bg-brand-accent text-white border-brand-accent' : 'border-brand-border bg-transparent text-brand-dark hover:border-brand-dark' }}">
                Importar JSON
            </a>
        </div>

        @if($activeTab === 'quotes')
            <div class="flex items-center justify-between gap-3 mb-6">
                <form action="{{ route('admin.panel') }}" method="GET" class="flex-1 max-w-sm">
                    <input type="hidden" name="tab" value="quotes">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Filtrar citações..." 
                           class="w-full px-3 py-2 text-xs bg-transparent border border-brand-border rounded-[2px] focus:outline-none focus:border-brand-accent text-brand-dark placeholder:text-brand-muted/60"
                           onchange="this.form.submit()">
                </form>

                <button @click="showNewForm = !showNewForm" type="button" class="px-4 py-2 bg-brand-dark text-white text-xs hover:bg-black transition-colors cursor-pointer">
                    Nova citação
                </button>
            </div>

            {{-- Create Quote Form --}}
            <div x-show="showNewForm" x-cloak x-transition class="border border-brand-border p-6 mb-8 rounded-[2px] bg-white/30">
                <form action="{{ route('admin.quotes.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-xs text-brand-muted mb-1.5 font-medium">Texto</label>
                        <textarea name="content" rows="3" required class="w-full p-3 text-xs bg-cream border border-brand-border rounded-[2px] focus:outline-none focus:border-brand-accent text-brand-dark"></textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div>
                            <label class="block text-xs text-brand-muted mb-1.5 font-medium">Autor</label>
                            <select name="author_id" class="w-full px-3 py-2 text-xs bg-cream border border-brand-border rounded-[2px] text-brand-dark">
                                @foreach($allAuthors as $author)
                                    <option value="{{ $author->id }}">{{ $author->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs text-brand-muted mb-1.5 font-medium">Categorias</label>
                            <select name="category_ids[]" multiple class="w-full px-3 py-2 text-xs bg-cream border border-brand-border rounded-[2px] h-24 text-brand-dark">
                                @foreach($allCategories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="flex items-center gap-2">
                        <button type="submit" class="px-5 py-2 bg-brand-dark text-white text-xs hover:bg-black transition-colors">Guardar</button>
                        <button type="button" @click="showNewForm = false" class="px-5 py-2 border border-brand-border text-xs text-brand-dark hover:bg-black/5">Cancelar</button>
                    </div>
                </form>
            </div>

            {{-- Quotes List --}}
            <div class="divide-y divide-brand-border/60 border-t border-brand-border/60">
                @foreach($quotes as $quote)
                    <div class="py-5" x-data="{ editing: false }">
                        <div x-show="!editing">
                            <p class="font-serif text-lg text-brand-dark leading-snug mb-2">{{ $quote->content }}</p>
                            <div class="text-xs text-brand-muted flex items-center gap-2">
                                <span>{{ $quote->author->name }}</span>
                                <span>·</span>
                                <span>{{ $quote->categories->pluck('name')->join(', ') }}</span>
                                <span class="ml-2">
                                    <button @click="editing = true" class="text-brand-muted hover:text-brand-dark underline cursor-pointer">Editar</button>
                                </span>
                                <span>
                                    <form action="{{ route('admin.quotes.destroy', $quote) }}" method="POST" class="inline" onsubmit="return confirm('Apagar esta citação?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-brand-danger hover:underline ml-1 cursor-pointer">Apagar</button>
                                    </form>
                                </span>
                            </div>
                        </div>

                        {{-- Edit Quote Form --}}
                        <div x-show="editing" x-cloak x-transition class="pt-2">
                            <form action="{{ route('admin.quotes.update', $quote) }}" method="POST">
                                @csrf @method('PUT')
                                <textarea name="content" rows="3" required class="w-full p-3 text-xs bg-cream border border-brand-border rounded-[2px] mb-3 text-brand-dark">{{ $quote->content }}</textarea>
                                <div class="grid grid-cols-2 gap-4 mb-4">
                                    <select name="author_id" class="w-full px-3 py-2 text-xs bg-cream border border-brand-border text-brand-dark">
                                        @foreach($allAuthors as $author)
                                            <option value="{{ $author->id }}" {{ $quote->author_id == $author->id ? 'selected' : '' }}>{{ $author->name }}</option>
                                        @endforeach
                                    </select>
                                    <select name="category_ids[]" multiple class="w-full px-3 py-2 text-xs bg-cream border border-brand-border h-20 text-brand-dark">
                                        @foreach($allCategories as $category)
                                            <option value="{{ $category->id }}" {{ $quote->categories->contains($category->id) ? 'selected' : '' }}>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="flex gap-2">
                                    <button type="submit" class="px-4 py-1.5 bg-brand-dark text-white text-xs hover:bg-black">Atualizar</button>
                                    <button type="button" @click="editing = false" class="px-4 py-1.5 border border-brand-border text-xs text-brand-dark hover:bg-black/5">Cancelar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        {{-- TAB 2: AUTORES --}}
        @if($activeTab === 'authors')
            <form action="{{ route('admin.authors.store') }}" method="POST" class="flex items-center gap-3 mb-8">
                @csrf
                <input type="text" name="name" placeholder="Nome do autor..." required class="flex-1 max-w-sm px-3 py-2 text-xs bg-cream border border-brand-border text-brand-dark">
                <button type="submit" class="px-4 py-2 bg-brand-dark text-white text-xs hover:bg-black transition-colors">Adicionar</button>
            </form>

            <div class="divide-y divide-brand-border/60 border-t border-brand-border/60">
                @foreach($authors as $author)
                    <div class="py-4" x-data="{ editing: false }">
                        <div x-show="!editing" class="flex justify-between items-center">
                            <h2 class="font-serif text-lg text-brand-dark font-normal">{{ $author->name }}</h2>
                            <div class="text-xs text-brand-muted flex items-center gap-4">
                                <span>{{ $author->quotes_count }} citações</span>
                                <button @click="editing = true" class="text-brand-muted hover:text-brand-dark underline cursor-pointer">Renomear</button>
                                <form action="{{ route('admin.authors.destroy', $author) }}" method="POST" class="inline" onsubmit="return confirm('Apagar autor?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-brand-danger hover:underline cursor-pointer">Apagar</button>
                                </form>
                            </div>
                        </div>

                        <div x-show="editing" x-cloak class="flex gap-2 items-center py-1">
                            <form action="{{ route('admin.authors.update', $author) }}" method="POST" class="flex gap-2 items-center w-full">
                                @csrf @method('PUT')
                                <input type="text" name="name" value="{{ $author->name }}" required class="px-3 py-1.5 text-xs bg-cream border border-brand-border text-brand-dark flex-1">
                                <button type="submit" class="px-3 py-1.5 bg-brand-dark text-white text-xs">Guardar</button>
                                <button type="button" @click="editing = false" class="px-3 py-1.5 border border-brand-border text-xs text-brand-dark">Cancelar</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        {{-- TAB 3: CATEGORIAS --}}
        @if($activeTab === 'categories')
            <form action="{{ route('admin.categories.store') }}" method="POST" class="flex items-center gap-3 mb-8">
                @csrf
                <input type="text" name="name" placeholder="Nome da categoria..." required class="flex-1 max-w-sm px-3 py-2 text-xs bg-cream border border-brand-border text-brand-dark">
                <button type="submit" class="px-4 py-2 bg-brand-dark text-white text-xs hover:bg-black transition-colors">Adicionar</button>
            </form>

            <div class="divide-y divide-brand-border/60 border-t border-brand-border/60">
                @foreach($categories as $category)
                    <div class="py-4" x-data="{ editing: false }">
                        <div x-show="!editing" class="flex justify-between items-center">
                            <h2 class="font-serif text-lg text-brand-dark font-normal">{{ $category->name }}</h2>
                            <div class="text-xs text-brand-muted flex items-center gap-4">
                                <span>{{ $category->quotes_count }} citações</span>
                                <button @click="editing = true" class="text-brand-muted hover:text-brand-dark underline cursor-pointer">Renomear</button>
                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline" onsubmit="return confirm('Apagar categoria?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-brand-danger hover:underline cursor-pointer">Apagar</button>
                                </form>
                            </div>
                        </div>

                        <div x-show="editing" x-cloak class="flex gap-2 items-center py-1">
                            <form action="{{ route('admin.categories.update', $category) }}" method="POST" class="flex gap-2 items-center w-full">
                                @csrf @method('PUT')
                                <input type="text" name="name" value="{{ $category->name }}" required class="px-3 py-1.5 text-xs bg-cream border border-brand-border text-brand-dark flex-1">
                                <button type="submit" class="px-3 py-1.5 bg-brand-dark text-white text-xs">Guardar</button>
                                <button type="button" @click="editing = false" class="px-3 py-1.5 border border-brand-border text-xs text-brand-dark">Cancelar</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        @if($activeTab === 'bulk')
            <div class="max-w-xl">
                <div class="mb-6">
                    <h2 class="font-serif text-2xl text-brand-dark font-normal mb-1">Importação em Massa</h2>
                    <p class="text-xs text-brand-muted leading-relaxed">
                        Envie um ficheiro JSON para importar múltiplas citações de uma só vez. Se o autor ou a categoria não existirem, serão criados automaticamente.
                    </p>
                </div>

                {{-- Upload Form --}}
                <form action="{{ route('admin.quotes.bulk') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    
                    <div class="border-2 border-dashed border-brand-border hover:border-brand-dark p-8 rounded-[2px] text-center transition-colors bg-white/20">
                        <label for="json_file" class="cursor-pointer block">
                            <svg class="mx-auto h-8 w-8 text-brand-muted mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                            </svg>
                            <span class="text-xs font-medium text-brand-dark block mb-1">Escolher ficheiro JSON</span>
                            <span class="text-[11px] text-brand-muted block">Máximo: 2MB (.json)</span>
                        </label>
                        <input id="json_file" name="json_file" type="file" accept=".json,application/json" required class="hidden" onchange="document.getElementById('file-name').textContent = this.files[0]?.name || ''">
                        <div id="file-name" class="mt-3 text-xs font-mono text-brand-accent"></div>
                    </div>

                    <button type="submit" class="px-6 py-2.5 bg-brand-dark text-white text-xs hover:bg-black transition-colors">
                        Processar e Importar
                    </button>
                </form>

                {{-- Expected Format Guidance --}}
                <div class="mt-10 pt-6 border-t border-brand-border/60">
                    <span class="text-[10px] tracking-[0.2em] text-brand-muted uppercase font-semibold block mb-2">Estrutura Esperada (JSON)</span>
                    <pre class="bg-cream border border-brand-border p-4 text-[11px] font-mono text-brand-dark rounded-[2px] overflow-x-auto leading-relaxed">[
    {
        "quote": "O poeta é um fingidor.",
        "author": "Fernando Pessoa",
        "category": "Poesia"
    },
    {
        "quote": "A liberdade é pouco. O que eu desejo ainda não tem nome.",
        "author": "Clarice Lispector",
        "category": ["Filosofia", "Literatura"]
    }
]</pre>
                </div>
            </div>
        @endif
    </div>

</x-admin-layout>