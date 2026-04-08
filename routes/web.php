<?php

use Illuminate\Support\Facades\Route;

#================= VIEWERS =================
Route::get('/', function () {
    return view('viewers.pages.home');
});

#================= ADMIN =================
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