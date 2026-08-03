<?php

namespace App\Http\Controllers;

use App\Services\CategoryService;
use Illuminate\Contracts\View\View;

class CategoryController extends Controller
{
    public function __construct(
        protected CategoryService $categoryService
    ) {}

    public function index(): View
    {
        $categories = $this->categoryService->getAllCategories();

        return view('categories.index', compact('categories'));
    }

    public function show(string $slug): View
    {
        [$category, $quotes] = $this->categoryService->getCategoryBySlug($slug);

        return view('categories.show', compact('category', 'quotes'));
    }

    public function storeCategory(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:categories,name'],
            'description' => ['nullable', 'string'],
        ]);

        $this->categoryService->createCategory($validated);
        return redirect()->route('admin.panel', ['tab' => 'categories'])->with('success', 'Categoria criada.');
    }

    public function updateCategory(Request $request, Category $category): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:categories,name,' . $category->id],
            'description' => ['nullable', 'string'],
        ]);

        $this->categoryService->updateCategory($category, $validated);
        return redirect()->route('admin.panel', ['tab' => 'categories'])->with('success', 'Categoria atualizada.');
    }

    public function destroyCategory(Category $category): RedirectResponse
    {
        $this->categoryService->deleteCategory($category);
        return redirect()->route('admin.panel', ['tab' => 'categories'])->with('success', 'Categoria eliminada.');
    }
}