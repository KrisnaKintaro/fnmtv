<?php

use App\Http\Controllers\Admin\KategoriController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('admin/manajemen_kategori')->group(function() {
    Route::get('/ambilData',[KategoriController::class, 'getDaftarKategori']);
    Route::post('/tambahData', [KategoriController::class, 'tambahKategoriBaru']);
    Route::put('/ubahData/{id}', [KategoriController::class, 'ubahDataKategori']);
    Route::delete('/hapusData/{id}', [KategoriController::class, 'hapusKategori']);
});

