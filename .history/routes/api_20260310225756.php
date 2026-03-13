<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// ============================================
// UC-12: Fitur Reaksi Emote (AJAX - tanpa reload)
// ============================================
Route::post('/reactions/{news}', [ReactionController::class, 'store'])
    ->name('api.reactions.store');

Route::get('/reactions/{news}', [ReactionController::class, 'show'])
    ->name('api.reactions.show');

// ============================================
// UC-13: Kolom Komentar (AJAX - tanpa reload)
// ============================================
Route::post('/comments', [CommentController::class, 'store'])
    ->name('api.comments.store');

Route::get('/comments/{news}', [CommentController::class, 'index'])
    ->name('api.comments.index');

// ============================================
// UC-10: Pencarian Berita (Live Search)
// ============================================
Route::get('/search', [SearchController::class, 'index'])
    ->name('api.search');

// ============================================
// UC-14: View Counter (dipanggil saat artikel dibuka)
// ============================================
Route::post('/views/{news}', [ViewCountController::class, 'increment'])
    ->name('api.views.increment');