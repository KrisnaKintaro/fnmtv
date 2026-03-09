<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('user');
});


Route::get('/berita', function(){
    return view('berita');
});
