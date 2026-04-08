<?php

use Illuminate\Support\Facades\Route;

#================= VIEWERS =================
Route::get('/', function () {
    return view('viewers.pages.home');
});

#================= ADMIN =================
Route::get('/', function () {
    return view('viewers.pages.home');
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

