<?php

use Illuminate\Support\Facades\Route;

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

#================= ADMIN ===================
Route::get('/kategori', function () {
    return view('Admin.pages.manajemen_kategori');
});

Route::get('/komentar', function () {
    return view('Admin.pages.komentar');
});

Route::get('/analitik_statistik_berita', function(){
    return view('Admin.pages.analitikStatistikBerita');
});

Route::get('/finansial', function () {
    return view('Admin.pages.finansial');
});

Route::get('/user', function () {
    return view('Admin.pages.manajemen_user');
});

Route::get('/pengaturan', function () {
    return view('Admin.pages.pengaturan');
});

#================= EDITOR =================
Route::get('/editor', function () {
    return view('editor.pages.berita_saya');
});

Route::get('/berita-saya', function () {
    return view('editor.pages.berita_saya');
});

Route::get('/tulis-editor', function () {
    return view('editor.pages.tulis_berita');
});
#================= REDAKSI =================

Route::get('/redaksi-manajemen-berita', function () {
    return view('Redaksi.pages.manajemen_berita');
});

#================= AUTH =================
Route::get('/login', function () {
    return view('Auth.login');
})->name('login');

Route::get('/register', function () {
    return view('Auth.register');
})->name('register');


