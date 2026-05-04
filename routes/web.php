<?php

use App\Http\Controllers\Auth\AuthController;
use App\Models\User;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PengaturanController;


#================= VERIFIKASI EMAIL =================
// Halaman pemberitahuan "Cek Email"

Route::prefix('email')->group(function () {
    Route::get('/verify', function () {
        return view('Auth.verifyEmail');
    })->middleware('auth')->name('verification.notice');

    // Proses saat link di email diklik (Tetap di web karena merespons HTML/Browser)
    Route::get('/verify/{id}/{hash}', [AuthController::class, 'verifyEmail'])
        ->middleware(['signed'])
        ->name('verification.verify');
});

#================= LUPA PASSWORD =================
// Tampilan Lupa Password 
Route::view('/forgot-password', 'Auth.forgotPassword')
    ->middleware('guest')
    ->name('password.request');

// Tampilan Reset Password (Pakai closure karena butuh nangkep $token dan $request->email)
Route::get('/reset-password/{token}', function (Request $request, $token) {
    return view('Auth.resetPassword', [
        'token' => $token,
        'email' => $request->query('email')
    ]);
})->middleware('guest')->name('password.reset');

#================= VIEWERS =================
Route::get('/', function () {
    return view('viewers.pages.home');
    // return view('viewers.pages.tampilanDetilBerita');
    // return view('viewers.pages.tampilanTiapKategori');
});

Route::get('/search', function () {
    return view('Viewers.pages.beritaHasilSearch');
});

Route::get('/kategori/{slug}', function () {
    return view('Viewers.pages.tampilanTiapKategori');
});

Route::get('berita/{slug}', function () {
    return view('Viewers.pages.tampilanDetilBerita');
});
Route::middleware(['auth', 'RoleCheck:Viewer'])->group(function () {
    Route::get('/profil', fn() => view('Viewers.pages.userProfil'));
});

#================= ADMIN ===================
Route::middleware(['auth', 'RoleCheck:Admin'])->group(function () {
    Route::get('/kategori', function () {
        return view('Admin.pages.manajemen_kategori');
    });

    Route::get('/komentar', function () {
        return view('Admin.pages.komentar');
    });

    Route::get('/analitik_statistik_berita', function () {
        return view('Admin.pages.analitikStatistikBerita');
    });

    Route::get('/finansial', function () {
        return view('Admin.pages.finansial');
    });

    Route::get('/user', function () {
        return view('Admin.pages.manajemen_user');
    });

    Route::get('/pengaturan', [PengaturanController::class, 'index']);
    Route::post('/pengaturan', [PengaturanController::class, 'updateIdentity']);
    Route::post('/pengaturan/password', [PengaturanController::class, 'updatePassword']);
    
});

#================= EDITOR =================
Route::middleware(['auth', 'RoleCheck:Editor'])->group(function () {
    Route::get('/editor', function () {
        return view('editor.pages.berita_saya');
    });

    Route::get('/berita-saya', function () {
        return view('editor.pages.berita_saya');
    });

    Route::get('/tulis-editor', function () {
        return view('editor.pages.tulis_berita');
    });
});
#================= REDAKSI =================
Route::middleware(['auth', 'RoleCheck:Redaksi'])->group(function () {
    Route::get('/redaksi-manajemen-berita', fn() => view('Redaksi.pages.manajemen_berita'));
});

#================= AUTH =================
Route::get('/login', function () {
    return view('Auth.login');
})->name('login');

Route::get('/register', function () {
    return view('Auth.register');
})->name('register');
