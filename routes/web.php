<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\PanelController;
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
    $stats = Cache::remember('about_page_stats', now()->addHours(12), function () {
        return [
            'quotes_count'  => Quote::count(),
            'authors_count' => Author::has('quotes')->count(),
        ];
    });

    return view('about', $stats);
})->name('about');


Route::middleware('guest')->prefix('admin')->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])
        ->middleware('throttle:login')
        ->name('admin.login.submit');
});

Route::middleware(['auth'])->prefix('admin')->as('admin.')->group(function () {
    Route::get('/dashboard', [PanelController::class, 'index'])->name('dashboard');
    Route::get('/panel', [PanelController::class, 'index'])->name('panel');

    Route::post('/quotes', [QuoteController::class, 'storeQuote'])->name('quotes.store');
    Route::put('/quotes/{quote}', [QuoteController::class, 'updateQuote'])->name('quotes.update');
    Route::delete('/quotes/{quote}', [QuoteController::class, 'destroyQuote'])->name('quotes.destroy');

    Route::post('/authors', [AuthorController::class, 'storeAuthor'])->name('authors.store');
    Route::put('/authors/{author}', [AuthorController::class, 'updateAuthor'])->name('authors.update');
    Route::delete('/authors/{author}', [AuthorController::class, 'destroyAuthor'])->name('authors.destroy');

    Route::post('/categories', [CategoryController::class, 'storeCategory'])->name('categories.store');
    Route::put('/categories/{category}', [CategoryController::class, 'updateCategory'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroyCategory'])->name('categories.destroy');

    Route::post('/quotes/bulk', [PanelController::class, 'bulkStore'])->name('quotes.bulk');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});