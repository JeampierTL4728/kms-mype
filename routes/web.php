<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\DashboardController;

Route::get('/', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/articulos/crear', [ArticleController::class, 'create'])->name('articles.create');
Route::post('/articulos', [ArticleController::class, 'store'])->name('articles.store');
Route::get('/articulos/{id}', [ArticleController::class, 'show'])->name('articles.show');
Route::get('/articulos/{id}/editar', [ArticleController::class, 'edit'])->name('articles.edit');
Route::put('/articulos/{id}', [ArticleController::class, 'update'])->name('articles.update');
Route::delete('/articulos/{id}', [ArticleController::class, 'destroy'])->name('articles.destroy');