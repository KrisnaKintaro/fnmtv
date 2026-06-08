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
        return view('auth.verifyemail');
    })->middleware('auth')->name('verification.notice');

    // Proses saat link di email diklik (Tetap di web karena merespons HTML/Browser)
    Route::get('/verify/{id}/{hash}', [AuthController::class, 'verifyEmail'])
        ->middleware(['signed'])
        ->name('verification.verify');
});

#================= LUPA PASSWORD =================
// Tampilan Lupa Password
Route::view('/forgot-password', 'auth.forgotpassword')
    ->middleware('guest')
    ->name('password.request');

// Tampilan Reset Password (Pakai closure karena butuh nangkep $token dan $request->email)
Route::get('/reset-password/{token}', function (Request $request, $token) {
    return view('auth.resetpassword', [
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
    return view('viewers.pages.beritahasilsearch');
});

Route::get('/tentang-kami', function () {
    return view('viewers.pages.about');
});
#================= ADMIN =================

Route::get('/kategori/{slug}', function () {
    return view('viewers.pages.tampilantiapkategori');
});

Route::get('berita/{slug}', function () {
    return view('viewers.pages.tampilandetilberita');
});
// Route::middleware(['auth', 'RoleCheck:Viewer'])->group(function () {
//     Route::get('/profil', fn() => view('Viewers.pages.userProfil'));
// });

Route::get('/profil', fn() => view('viewers.pages.userprofil'));

#================= ADMIN ===================
Route::middleware(['auth', 'RoleCheck:Admin'])->group(function () {
    Route::get('/kategori', function () {
        return view('admin.pages.manajemen_kategori');
    });

    Route::get('/komentar', function () {
        return view('admin.pages.komentar');
    });

    Route::get('/analitik_statistik_berita', function () {
        return view('admin.pages.analitikstatistikberita');
    });

    Route::get('/finansial', function () {
        return view('admin.pages.finansial');
    });

    Route::get('/user', function () {
        return view('admin.pages.manajemen_user');
    });

    Route::get('/promo-iklan', function () {
        return view('admin.pages.manajemen_iklan');
    });

    Route::get('/pengaturan', [PengaturanController::class, 'index']);
    Route::post('/pengaturan', [PengaturanController::class, 'updateIdentity']);
    Route::post('/pengaturan/password', [PengaturanController::class, 'updatePassword']);
});

#================= EDITOR =================
Route::middleware(['auth', 'RoleCheck:Editor'])->group(function () {
    Route::get('/editor',          fn() => view('editor.pages.berita_saya'));
    Route::get('/editor/profil',   fn() => view('editor.pages.profil')); // ← ubah ini
    Route::get('/berita-saya',     fn() => view('editor.pages.berita_saya'));
    Route::get('/tulis-editor',    fn() => view('editor.pages.tulis_berita'));
});
#================= REDAKSI =================
Route::middleware(['auth', 'RoleCheck:Redaksi'])->group(function () {
    Route::get('/redaksi-manajemen-berita', fn() => view('redaksi.pages.manajemen_berita'));
    Route::get('/redaksi/profil', fn() => view('redaksi.pages.profil'));
});

#================= AUTH =================
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

