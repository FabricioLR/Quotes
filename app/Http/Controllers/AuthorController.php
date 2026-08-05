<?php

namespace App\Http\Controllers;

use App\Services\AuthorService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Author;

class AuthorController extends Controller
{
    public function __construct(
        protected AuthorService $authorService
    ) {}

    public function index(): View
    {
        $authors = $this->authorService->getAllAuthors();

        return view('authors.index', compact('authors'));
    }

    public function show(string $slug): View
    {
        [$author, $quotes] = $this->authorService->getAuthorBySlug($slug);

        return view('authors.show', compact('author', 'quotes'));
    }

    public function storeAuthor(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:authors,name'],
            'bio' => ['nullable', 'string'],
        ]);

        $this->authorService->createAuthor($validated);
        return redirect()->route('admin.panel', ['tab' => 'authors'])->with('success', 'Autor criado.');
    }

    public function updateAuthor(Request $request, Author $author): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:authors,name,' . $author->id],
            'bio' => ['nullable', 'string'],
        ]);

        $this->authorService->updateAuthor($author, $validated);
        return redirect()->route('admin.panel', ['tab' => 'authors'])->with('success', 'Autor atualizado.');
    }

    public function destroyAuthor(Author $author): RedirectResponse
    {
        $this->authorService->deleteAuthor($author);
        return redirect()->route('admin.panel', ['tab' => 'authors'])->with('success', 'Autor eliminado.');
    }
}
