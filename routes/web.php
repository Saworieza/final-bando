<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardRedirectController;
use App\Http\Controllers\AdminUserApprovalController;
use App\Http\Controllers\Seller\ProductController;

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
    
    // Only for sellers
    Route::middleware('role:Seller')->prefix('seller')->group(function () {
        Route::resource('products', ProductController::class);
    });

    Route::middleware('role:Seller')->get('/test-role', function () {
        return 'Seller middleware is working!';
    });
});

//Pending Approval
Route::view('/pending-approval', 'auth.pending-approval')->name('pending.approval');


// Breeze auth routes (login, register, etc.)
require __DIR__.'/auth.php';
