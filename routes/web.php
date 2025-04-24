<?php

use App\Models\Book;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\PublisherController;

Route::get('/', [BookController::class, 'index'])->name('dashboard');
Route::resource('publishers', PublisherController::class);
Route::get('/books', [BookController::class, 'index'])->name('books.index');
Route::get('/create', [BookController::class, 'create']);
Route::post('/store', [BookController::class, 'store'])->name('store');
Route::put('/update/{id}', [BookController::class, 'update'])->name('update');
Route::delete('/destroy/{id}', [BookController::class, 'destroy'])->name('destroy');