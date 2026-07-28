<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\SearchController;
use App\Models\Author;
use App\Models\Quote;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/categorias', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categoria/{category:slug}', [CategoryController::class, 'show'])->name('categories.show');

Route::get('/autores', [AuthorController::class, 'index'])->name('authors.index');
Route::get('/autor/{author:slug}', [AuthorController::class, 'show'])->name('authors.show');

Route::get('/pesquisar', SearchController::class)->name('search');

Route::get('/sobre', function () {
    // Cache counts for 12 hours to keep page loads fast
    $stats = Cache::remember('about_page_stats', now()->addHours(12), function () {
        return [
            'quotes_count'  => Quote::count(),
            'authors_count' => Author::has('quotes')->count(),
        ];
    });

    return view('about', $stats);
})->name('about');