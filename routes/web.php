<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardRedirectController;
use App\Http\Controllers\AdminUserApprovalController;
use App\Http\Controllers\StoreProductController;
use App\Http\Controllers\BlogPostController;
use App\Http\Controllers\BlogCategoryController;
use App\Http\Controllers\PublicBlogController;
use App\Http\Controllers\QuoteController;

// Public homepage
Route::get('/', function () {
    return view('welcome');
});

// Dashboard redirect (role-based)
Route::get('/dashboard', [DashboardRedirectController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Authenticated user routes
Route::middleware('auth')->group(function () {
    // Profile management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin user approval
    Route::patch('/admin/approve-user/{user}', [AdminUserApprovalController::class, 'update'])
        ->name('admin.approve');
    
    // AUTH CRUD - Products
    Route::get('/dashboard/products', [StoreProductController::class, 'myProducts'])->name('products.my');
    Route::resource('products', StoreProductController::class)->except(['index', 'show']);
    
    // Quote Management Routes
    Route::get('/quotes', [QuoteController::class, 'index'])->name('quotes.index');
    Route::get('/quotes/create/{product}', [QuoteController::class, 'create'])->name('quotes.create');
    Route::post('/quotes', [QuoteController::class, 'store'])->name('quotes.store');
    Route::get('/quotes/{quote}', [QuoteController::class, 'show'])->name('quotes.show');
    Route::get('/quotes/{quote}/edit', [QuoteController::class, 'edit'])->name('quotes.edit');
    Route::put('/quotes/{quote}', [QuoteController::class, 'update'])->name('quotes.update');
    Route::delete('/quotes/{quote}', [QuoteController::class, 'destroy'])->name('quotes.destroy');
    
    // Quote actions
    Route::post('/quotes/{quote}/accept', [QuoteController::class, 'accept'])->name('quotes.accept');
    Route::post('/quotes/{quote}/reject', [QuoteController::class, 'reject'])->name('quotes.reject');
    Route::post('/quotes/{quote}/fulfill', [QuoteController::class, 'fulfill'])->name('quotes.fulfill');
    
    // AJAX route for quick quote creation
    Route::post('/quotes/quick-store', [QuoteController::class, 'quickStore'])->name('quotes.quick-store');
});

// PUBLIC viewable - Products
Route::get('/products', [StoreProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [StoreProductController::class, 'show'])->name('products.show');

// ADMIN ONLY - Blog Management
Route::middleware(['role:Admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('blog/posts', BlogPostController::class);
    Route::resource('blog/categories', BlogCategoryController::class);
});

// PUBLIC - Blog Views
Route::get('/blog', [BlogPostController::class, 'publicIndex'])->name('blog.index');
Route::get('/blog/category/{slug}', [BlogPostController::class, 'byCategory'])->name('blog.category');
Route::get('/blog/{slug}', [BlogPostController::class, 'publicShow'])->name('blog.show');

// Other routes
Route::view('/pending-approval', 'auth.pending-approval')->name('pending.approval');

Route::get('/search', function () {
    // implement search logic
})->name('search');

Route::get('/cart', function () {
    return 'Cart will go here';
})->name('cart.index');

Route::get('/distributors', function () {
    return view('pages.distributors');
})->name('distributors');

Route::get('/lang/{locale}', function ($locale) {
    session(['locale' => $locale]);
    app()->setLocale($locale);
    return back();
})->name('lang.switch');

// Breeze auth routes (login, register, etc.)
require __DIR__.'/auth.php';