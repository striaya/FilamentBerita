<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\NewsController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingController::class, 'index'])->name('landing');

Route::get('/berita', [NewsController::class, 'index'])->name('news.index');
Route::get('/berita/kategori/{slug}', [NewsController::class, 'category'])->name('news.category');
Route::get('/berita/{slug}', [NewsController::class, 'show'])->name('news.show');

Route::get('/author/{username}', [AuthorController::class, 'show'])->name('author.show');
