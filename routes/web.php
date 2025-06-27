<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardRedirectController;
use App\Http\Controllers\AdminUserApprovalController;
use App\Http\Controllers\StoreProductController;

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
    
    
    // AUTH CRUD
    // Authenticated (Seller/Admin only)
    Route::get('/dashboard/products', [StoreProductController::class, 'myProducts'])->name('products.my');
    Route::resource('products', StoreProductController::class)->except(['index', 'show']);
    // Manual CRUD routes (excluding index/show which are public)
    
});

// PUBLIC viewable
    Route::get('/products', [StoreProductController::class, 'index'])->name('products.index');
    Route::get('/products/{product}', [StoreProductController::class, 'show'])->name('products.show');


//Pending Approval
Route::view('/pending-approval', 'auth.pending-approval')->name('pending.approval');

Route::get('/search', function () {
    // implement search logic
})->name('search');

Route::get('/cart', function () {
    return 'Cart will go here';
})->name('cart.index');

Route::get('/distributors', function () {
    return view('pages.distributors'); // or whatever view you want
})->name('distributors');

Route::get('/lang/{locale}', function ($locale) {
    session(['locale' => $locale]);
    app()->setLocale($locale);
    return back();
})->name('lang.switch');



// Breeze auth routes (login, register, etc.)
require __DIR__.'/auth.php';


