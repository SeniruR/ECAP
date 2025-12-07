<?php

use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ItemController as AdminItemController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ItemController::class, 'index'])->name('home');
Route::get('/listall', [ItemController::class, 'listAll'])->name('listall');
Route::get('/item/{no}', [ItemController::class, 'show'])->name('item.show');
Route::view('/about', 'about')->name('about');
Route::get('/contact', [App\Http\Controllers\ContactController::class, 'show'])->name('contact');
Route::post('/contact', [App\Http\Controllers\ContactController::class, 'send'])->name('contact.send');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified', 'admin', 'throttle:30,1'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/items', [AdminItemController::class, 'index'])->name('items.index');
    Route::get('/items/create', [AdminItemController::class, 'create'])->name('items.create');
    Route::get('/items/{no}/edit', [AdminItemController::class, 'edit'])->name('items.edit');
    Route::post('/items', [AdminItemController::class, 'store'])->name('items.store');
    Route::post('/items/{no}/toggle', [AdminItemController::class, 'toggle'])->name('items.toggle');
    Route::delete('/items/{no}', [AdminItemController::class, 'destroy'])->name('items.destroy');
    // Categories (legacy admin pages)
    Route::get('/categories', [AdminCategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [AdminCategoryController::class, 'create'])->name('categories.create');
    Route::get('/categories/{no}/edit', [AdminCategoryController::class, 'edit'])->name('categories.edit');
    Route::post('/categories', [AdminCategoryController::class, 'store'])->name('categories.store');
    Route::post('/categories/{no}/toggle', [AdminCategoryController::class, 'toggle'])->name('categories.toggle');
    Route::delete('/categories/{no}', [AdminCategoryController::class, 'destroy'])->name('categories.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
