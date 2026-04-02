<?php

use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\moderasiKomentarController;
use App\Http\Controllers\Admin\TrackingPembayaranController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


















Route::prefix('admin/manajemen_kategori')->group(function() {
    Route::get('/ambilData',[KategoriController::class, 'getDaftarKategori']);
    Route::post('/tambahData', [KategoriController::class, 'tambahKategoriBaru']);
    Route::put('/ubahData/{id_kategori}', [KategoriController::class, 'ubahDataKategori']);
    Route::delete('/hapusData/{id_kategori}', [KategoriController::class, 'hapusKategori']);
});

Route::prefix('admin/manajemen_user')->group(function() {
    Route::get('/ambilData',[UserController::class, 'getDaftarPengguna']);
    Route::post('/tambahData', [UserController::class, 'tambahPenggunaBaru']);
    Route::put('/ubahData/{id_user}', [UserController::class, 'ubahDataPengguna']);
    Route::delete('/hapusData/{id_user}', [UserController::class, 'hapusPengguna']);
});

Route::prefix('admin/manajemen_komentar')->group(function(){
    Route::get('/ambilData',[moderasiKomentarController::class, 'getDaftarKomentar']);
    Route::put('/ubahStatus/{id_komentar}',[moderasiKomentarController::class, 'ubahStatusModerasi']);
    Route::delete('/hapusKomentar/{id_komentar', [moderasiKomentarController::class, 'hapusKomentar']);
});


Route::prefix('admin/tracking_pembayaran')->group(function () {
    Route::get('/ambilData', [TrackingPembayaranController::class, 'getDaftarPembayaran']);
    Route::put('/updatePembayaran/{berita_id}', [TrackingPembayaranController::class, 'updatePembayaran']);
});
