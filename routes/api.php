<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// Pemanggilan api nanti harus pakai tambahan /api/
// karena bawaan laravel untuk ngambil api harus pakai imbuhan /api/
Route::get('/dataUser',[UserController::class, 'getDataUser']);
Route::post('/tambahDataUser',[UserController::class, 'insertDataUser']);
Route::put('/ubahDataUser/{id}',[UserController::class, 'updateDataUser']);
Route::delete('/hapusDataUser/{id}',[UserController::class, 'hapusDataUser']);

Route::get('/dataBerita');
