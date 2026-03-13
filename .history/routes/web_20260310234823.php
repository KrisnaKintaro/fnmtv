<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\AdminNews;
use App\Http\Controllers\AdminCategory;
use App\Http\Controllers\AdminComment;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\UserController;

// default route removed; home route defined later

// ============================================
// UC-01: LOGIN ADMIN
// ============================================
Route::get('/admin/login', [AuthController::class, 'showLogin'])
    ->name('admin.login')
    ->middleware('guest');

Route::post('/admin/login', [AuthController::class, 'login'])
    ->name('admin.login.post');

Route::post('/admin/logout', [AuthController::class, 'logout'])
    ->name('admin.logout')
    ->middleware('auth');

// ============================================
// ADMIN ROUTES (semua dilindungi auth + isAdmin)
// ============================================
Route::prefix('admin')
    ->name('admin.')
    // middleware removed for demo; add auth/isAdmin later
    ->group(function () {

        // shortcut /admin → dashboard
        Route::get('/', function(){ return redirect()->route('admin.dashboard'); });

        // UC-07: Dashboard Statistik
        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        // UC-02: Manajemen Berita
        Route::resource('news', AdminNews::class);

        // UC-04: Toggle status publikasi (Draft/Published)
        Route::patch('/news/{news}/toggle-status', [AdminNews::class, 'toggleStatus'])
            ->name('news.toggle-status');

        // UC-03: Manajemen Kategori
        Route::resource('categories', AdminCategory::class);

        // UC-06: Moderasi Komentar
        Route::resource('comments', AdminComment::class)->only(['index', 'destroy']);
        Route::patch('/comments/{comment}/approve', [AdminComment::class, 'approve'])
            ->name('comments.approve');

        // UC-05: Administrasi Finansial
        Route::resource('finance', FinanceController::class);
        Route::patch('/finance/{finance}/toggle-payment', [FinanceController::class, 'togglePayment'])
            ->name('finance.toggle-payment');

        // Manajemen User
        Route::resource('users', UserController::class);
    });

// ============================================
// VIEWER / PUBLIC ROUTES
// ============================================

// UC-08: Halaman utama - berita terbaru
Route::get('/', [HomeController::class, 'index'])->name('home');

// UC-09: Navigasi Kategori
Route::get('/kategori/{slug}', [CategoryController::class, 'show'])
    ->name('category.show');

// UC-10: Pencarian Berita
Route::get('/cari', [SearchController::class, 'index'])
    ->name('search');

// UC-11: Berita Trending
Route::get('/trending', [HomeController::class, 'trending'])
    ->name('trending');

// UC-14: Halaman detail berita (view counter dicatat di sini)
Route::get('/berita/{slug}', [NewsController::class, 'show'])
    ->name('news.show');