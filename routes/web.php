<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return redirect()->route('products.index');
});

// Rutas públicas
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show')->where('product', '[0-9]+');

Route::middleware(['auth'])->group(function () {
    // Rutas de Administrador
    Route::middleware(['auth', \App\Http\Middleware\IsAdmin::class])->group(function () {
        Route::get('/admin/dashboard', [\App\Http\Controllers\AdminDashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('/admin/users', [\App\Http\Controllers\UserController::class, 'adminIndex'])->name('admin.users');
        Route::post('/admin/users/{user}/toggle-admin', [\App\Http\Controllers\UserController::class, 'toggleAdmin'])->name('admin.users.toggle');
        Route::post('/admin/users/{user}/reset-password', [\App\Http\Controllers\UserController::class, 'resetPassword'])->name('admin.users.reset');
        Route::get('/dashboard', [ProductController::class, 'dashboard'])->name('products.dashboard');
        Route::patch('/products/{product}/toggle-active', [ProductController::class, 'toggleActive'])->name('products.toggleActive');
        Route::resource('products', ProductController::class)->except(['index', 'show']);
    });

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/profile/info', [ProfileController::class, 'info'])->name('profile.info');
    Route::patch('/profile/info', [ProfileController::class, 'updateInfo'])->name('profile.info.update');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Logout GET route for convenience (public)
Route::get('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout.get');

require __DIR__.'/auth.php';