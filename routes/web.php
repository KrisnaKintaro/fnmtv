<?php

use Illuminate\Support\Facades\Route;

#================= ADMIN =================
Route::get('/', function () {
    return view('viewers.pages.home');
});

Route::get('/berita', function () {
    return view('Admin.pages.manajemen_berita');
});

Route::get('/tulis', function () {
    return view('Admin.pages.tulis_berita');
});

Route::get('/kategori', function () {
    return view('Admin.pages.manajemen_kategori');
});

Route::get('/komentar', function () {
    return view('Admin.pages.komentar');
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
Route::get('/berita-saya', function () {
    return view('Admin.pages.Editor.berita_saya');
});

#================= REDAKSI =================
Route::get('/manajemen-redaksi', function () {
    return view('Admin.pages.Redaksi.manajemen_berita');
});

