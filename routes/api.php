<?php

use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


















Route::prefix('admin/manajemen_kategori')->group(function() {
    Route::get('/ambilData',[KategoriController::class, 'getDaftarKategori']);
    Route::post('/tambahData', [KategoriController::class, 'tambahKategoriBaru']);
    Route::put('/ubahData/{id}', [KategoriController::class, 'ubahDataKategori']);
    Route::delete('/hapusData/{id}', [KategoriController::class, 'hapusKategori']);
});

Route::prefix('admin/manajemen_user')->group(function() {
    Route::get('/ambilData',[UserController::class, 'getDaftarPengguna']);
    Route::post('/tambahData', [UserController::class, 'tambahPenggunaBaru']);
    Route::put('/ubahData/{id_user}', [UserController::class, 'ubahDataPengguna']);
    Route::delete('/hapusData/{id_user}', [UserController::class, 'hapusPengguna']);
});
