<?php

namespace App\Http\Controllers;

use App\Services\AuthorService;
use Illuminate\Contracts\View\View;

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
}
