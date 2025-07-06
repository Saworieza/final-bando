<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardRedirectController;
use App\Http\Controllers\AdminUserApprovalController;
use App\Http\Controllers\StoreProductController;
use App\Http\Controllers\BlogPostController;
use App\Http\Controllers\BlogCategoryController;
use App\Http\Controllers\PublicBlogController;

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