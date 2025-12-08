<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactMessageController;
use App\Http\Controllers\Admin\ContactMessagesController;

// Public contact form submit (keeps legacy route name `contact.send`)
Route::post('/contact', [ContactMessageController::class, 'store'])->name('contact.send');

// Admin routes
Route::prefix('admin')->name('admin.')->middleware(['auth','admin'])->group(function () {
    Route::get('contacts', [ContactMessagesController::class, 'index'])->name('contacts.index');
    Route::get('contacts/{contactMessage}', [ContactMessagesController::class, 'show'])->name('contacts.show');
    Route::post('contacts/{contactMessage}/reply', [ContactMessagesController::class, 'reply'])->name('contacts.reply');
    Route::delete('contacts/{contactMessage}', [ContactMessagesController::class, 'destroy'])->name('contacts.destroy');
});
